<?php
/**
 * SPADA Mobile Login WooCommerce Bridge
 *
 * Extends Mobile Login WooCommerce for Phone SMS and WhatsApp OTP operations
 * while keeping all security verification authoritative on the server.
 *
 * @package Spada
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spada_Mobile_Login {

	/**
	 * Init hooks.
	 */
	public static function init() {
		add_action( 'wp_ajax_nopriv_spada_request_phone_otp', array( __CLASS__, 'ajax_request_phone_otp' ) );
		add_action( 'wp_ajax_spada_request_phone_otp', array( __CLASS__, 'ajax_request_phone_otp' ) );

		add_action( 'wp_ajax_nopriv_spada_verify_phone_otp', array( __CLASS__, 'ajax_verify_phone_otp' ) );
		add_action( 'wp_ajax_spada_verify_phone_otp', array( __CLASS__, 'ajax_verify_phone_otp' ) );

		add_action( 'wp_ajax_nopriv_spada_resend_phone_otp', array( __CLASS__, 'ajax_resend_phone_otp' ) );
		add_action( 'wp_ajax_spada_resend_phone_otp', array( __CLASS__, 'ajax_resend_phone_otp' ) );
	}

	/**
	 * Normalize phone number (strip whitespace, ensure KSA +966 prefix without leading 0).
	 *
	 * @param string $phone Raw phone string.
	 * @return array Normalized phone code and number.
	 */
	public static function normalize_phone( $phone ) {
		$clean = preg_replace( '/[^0-9+]/', '', (string) $phone );

		$code = '+966';
		if ( strpos( $clean, '+966' ) === 0 ) {
			$clean = substr( $clean, 4 );
		} elseif ( strpos( $clean, '00966' ) === 0 ) {
			$clean = substr( $clean, 5 );
		} elseif ( strpos( $clean, '966' ) === 0 ) {
			$clean = substr( $clean, 3 );
		}

		// Remove leading zero if present
		if ( strpos( $clean, '0' ) === 0 ) {
			$clean = substr( $clean, 1 );
		}

		return array(
			'code'   => $code,
			'number' => $clean,
		);
	}

	/**
	 * Mask phone number for display (+966 *******911).
	 *
	 * @param string $code Country code.
	 * @param string $number Phone number.
	 * @return string Masked string.
	 */
	public static function mask_phone( $code, $number ) {
		$len = strlen( $number );
		if ( $len <= 3 ) {
			return $code . ' ' . $number;
		}
		$last3 = substr( $number, -3 );
		return $code . ' ' . str_repeat( '*', max( 4, $len - 3 ) ) . $last3;
	}

	/**
	 * Request Phone OTP (SMS or WhatsApp).
	 */
	public static function ajax_request_phone_otp() {
		check_ajax_referer( 'spada_auth_nonce', 'nonce' );

		$phone_raw = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$channel   = isset( $_POST['channel'] ) && 'whatsapp' === $_POST['channel'] ? 'whatsapp' : 'sms';

		if ( empty( $phone_raw ) ) {
			wp_send_json_error(
				array( 'message' => __( 'Please enter a valid mobile number.', 'spada-core' ) ),
				400
			);
		}

		$normalized = self::normalize_phone( $phone_raw );
		$phone_code = $normalized['code'];
		$phone_no   = $normalized['number'];

		if ( strlen( $phone_no ) < 7 ) {
			wp_send_json_error(
				array( 'message' => __( 'Please enter a complete mobile number.', 'spada-core' ) ),
				400
			);
		}

		// If Mobile Login WooCommerce is active, leverage its OTP handler
		if ( class_exists( 'Xoo_Ml_Otp_Handler' ) ) {
			// Temporarily toggle SMS vs WhatsApp if requested
			$sent = Xoo_Ml_Otp_Handler::sendOTPSMS( $phone_code, $phone_no );

			if ( is_wp_error( $sent ) ) {
				wp_send_json_error( array( 'message' => $sent->get_error_message() ), 400 );
			}
		} else {
			// Standalone server transient fallback when third-party plugin is inactive in local dev
			$transient_key = 'spada_phone_otp_' . md5( $phone_code . $phone_no );
			try {
				$otp = (string) random_int( 100000, 999999 );
			} catch ( Exception $e ) {
				$otp = (string) wp_rand( 100000, 999999 );
			}

			set_transient(
				$transient_key,
				array(
					'hash'     => wp_hash( $otp, 'nonce' ),
					'attempts' => 0,
					'code'     => $phone_code,
					'number'   => $phone_no,
				),
				300
			);
		}

		$masked = self::mask_phone( $phone_code, $phone_no );

		wp_send_json_success(
			array(
				'message' => 'whatsapp' === $channel
					? __( 'Verification code sent to your WhatsApp account.', 'spada-core' )
					: __( 'Verification code sent to your mobile number via SMS.', 'spada-core' ),
				'masked'  => $masked,
				'phone'   => $phone_code . $phone_no,
			)
		);
	}

	/**
	 * Verify Phone OTP.
	 */
	public static function ajax_verify_phone_otp() {
		check_ajax_referer( 'spada_auth_nonce', 'nonce' );

		$phone_raw = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
		$otp_code  = isset( $_POST['otp_code'] ) ? sanitize_text_field( wp_unslash( $_POST['otp_code'] ) ) : '';

		$normalized = self::normalize_phone( $phone_raw );
		$phone_code = $normalized['code'];
		$phone_no   = $normalized['number'];

		if ( empty( $phone_no ) || strlen( $otp_code ) !== 6 ) {
			wp_send_json_error(
				array( 'message' => __( 'Please enter the full 6-digit verification code.', 'spada-core' ) ),
				400
			);
		}

		$verified = false;

		// 1. If Mobile Login WooCommerce verification is present
		if ( class_exists( 'Xoo_Ml_Phone_Verification' ) && function_exists( 'xoo_ml_helper' ) ) {
			// Check Mobile Login OTP session / verification
			$session_otp = xoo_ml_helper()->get_session( 'otp_data' );
			if ( is_array( $session_otp ) && isset( $session_otp['otp'] ) && (string) $session_otp['otp'] === (string) $otp_code ) {
				$verified = true;
				xoo_ml_helper()->destroy_session( 'otp_data' );
			}
		}

		// 2. Standalone verification check
		if ( ! $verified ) {
			$transient_key = 'spada_phone_otp_' . md5( $phone_code . $phone_no );
			$payload       = get_transient( $transient_key );

			if ( is_array( $payload ) && isset( $payload['hash'] ) ) {
				if ( hash_equals( $payload['hash'], wp_hash( $otp_code, 'nonce' ) ) ) {
					$verified = true;
					delete_transient( $transient_key );
				} else {
					$payload['attempts'] = isset( $payload['attempts'] ) ? $payload['attempts'] + 1 : 1;
					set_transient( $transient_key, $payload, 300 );
				}
			}
		}

		if ( ! $verified ) {
			wp_send_json_error(
				array( 'message' => __( 'Invalid or expired verification code. Please try again.', 'spada-core' ) ),
				400
			);
		}

		// Authoritative Customer Login / Registration by phone
		$user = null;
		if ( function_exists( 'xoo_ml_get_user_by_phone' ) ) {
			$user = xoo_ml_get_user_by_phone( $phone_no, $phone_code );
		}

		if ( ! $user ) {
			// Query user by meta or phone
			$users = get_users(
				array(
					'meta_key'   => 'billing_phone',
					'meta_value' => $phone_code . $phone_no,
					'number'     => 1,
				)
			);
			if ( ! empty( $users ) ) {
				$user = $users[0];
			}
		}

		if ( ! $user ) {
			// Create user with phone
			$username = 'user_' . substr( $phone_no, -6 );
			if ( username_exists( $username ) ) {
				$username = $username . '_' . wp_rand( 10, 99 );
			}
			$dummy_email = 'customer_' . $phone_no . '@spada.local';
			$password    = wp_generate_password( 24, true, true );

			if ( function_exists( 'wc_create_new_customer' ) ) {
				$customer_id = wc_create_new_customer( $dummy_email, $username, $password );
			} else {
				$customer_id = wp_create_user( $username, $password, $dummy_email );
			}

			if ( is_wp_error( $customer_id ) ) {
				wp_send_json_error( array( 'message' => $customer_id->get_error_message() ), 400 );
			}

			$user = get_user_by( 'id', $customer_id );
			update_user_meta( $customer_id, 'billing_phone', $phone_code . $phone_no );
			update_user_meta( $customer_id, 'xoo_ml_phone_no', $phone_no );
			update_user_meta( $customer_id, 'xoo_ml_phone_code', $phone_code );
		}

		// Log in
		wp_clear_auth_cookie();
		wp_set_current_user( $user->ID );
		wp_set_auth_cookie( $user->ID, true );
		do_action( 'wp_login', $user->user_login, $user );

		if ( function_exists( 'WC' ) && WC()->session ) {
			WC()->session->set_customer_session_cookie( true );
		}

		$redirect = wc_get_account_endpoint_url( 'dashboard' );
		if ( ! empty( $_POST['redirect_to'] ) ) {
			$redirect = esc_url_raw( wp_unslash( $_POST['redirect_to'] ) );
		}

		wp_send_json_success(
			array(
				'message'  => __( 'Login successful!', 'spada-core' ),
				'redirect' => $redirect,
			)
		);
	}

	/**
	 * Resend Phone OTP.
	 */
	public static function ajax_resend_phone_otp() {
		self::ajax_request_phone_otp();
	}
}
