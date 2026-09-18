<?php
/**
 * SPADA Fluid Checkout Customization Class
 *
 * Implements layout, Riyadh notice banner, field defaults,
 * trust badges, and Step 1/Step 2 UI matching Figma screenshots.
 *
 * @package Spada
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spada_FC {

	/**
	 * Init hooks.
	 */
	public static function init() {
		Spada_FC_Order_Summary::init();

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_assets' ), 20 );

		// Checkout alert banner
		add_action( 'woocommerce_before_checkout_form', array( __CLASS__, 'output_riyadh_alert_banner' ), 5 );
		add_action( 'fc_checkout_before', array( __CLASS__, 'output_riyadh_alert_banner' ), 5 );

		// Field defaults & customizations
		add_filter( 'woocommerce_checkout_fields', array( __CLASS__, 'customize_checkout_fields' ), 20 );
		add_filter( 'default_checkout_billing_country', array( __CLASS__, 'default_country' ) );
		add_filter( 'default_checkout_shipping_country', array( __CLASS__, 'default_country' ) );
		add_filter( 'default_checkout_billing_city', array( __CLASS__, 'default_city' ) );
		add_filter( 'default_checkout_shipping_city', array( __CLASS__, 'default_city' ) );
		add_filter( 'default_checkout_billing_state', array( __CLASS__, 'default_state' ) );
		add_filter( 'default_checkout_shipping_state', array( __CLASS__, 'default_state' ) );
		add_filter( 'default_checkout_billing_postcode', array( __CLASS__, 'default_postcode' ) );
		add_filter( 'default_checkout_shipping_postcode', array( __CLASS__, 'default_postcode' ) );

		// Map marker helper prompt
		add_action( 'woocommerce_after_checkout_shipping_form', array( __CLASS__, 'output_map_helper_prompt' ), 5 );

		// Step 2: Promo banner & Trust Badges
		add_action( 'woocommerce_review_order_before_submit', array( __CLASS__, 'output_free_delivery_banner' ), 10 );
		add_action( 'woocommerce_review_order_after_submit', array( __CLASS__, 'output_trust_badges' ), 20 );
		add_action( 'fc_checkout_after_place_order', array( __CLASS__, 'output_trust_badges' ), 20 );

		// Custom title classes
		add_filter( 'fc_checkout_page_title', array( __CLASS__, 'filter_checkout_page_title' ), 10, 2 );
	}

	/**
	 * Enqueue checkout assets.
	 */
	public static function enqueue_assets() {
		if ( ! function_exists( 'is_checkout' ) || ! is_checkout() || is_order_received_page() ) {
			return;
		}

		wp_enqueue_style(
			'spada-fluid-checkout',
			SPADA_CORE_URL . 'assets/css/fluid-checkout.css',
			array(),
			SPADA_CORE_VERSION
		);

		wp_enqueue_script(
			'spada-fluid-checkout',
			SPADA_CORE_URL . 'assets/js/fluid-checkout.js',
			array( 'jquery' ),
			SPADA_CORE_VERSION,
			true
		);

		wp_localize_script(
			'spada-fluid-checkout',
			'SpadaFCData',
			array(
				'shopUrl'           => function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' ),
				'isRtl'             => is_rtl(),
				'freeShipThreshold' => 250,
			)
		);
	}

	/**
	 * Output Riyadh notice banner.
	 */
	public static function output_riyadh_alert_banner() {
		static $displayed = false;
		if ( $displayed ) {
			return;
		}
		$displayed = true;
		?>
		<div class="spada-checkout-alert" role="alert">
			<span class="spada-alert-icon" aria-hidden="true">⚠️</span>
			<span class="spada-alert-text"><?php esc_html_e( 'Currently serving only in Riyadh, will expand soon.', 'spada-core' ); ?></span>
		</div>
		<?php
	}

	/**
	 * Default country to SA (Saudi Arabia).
	 */
	public static function default_country() {
		return 'SA';
	}

	/**
	 * Default city to Riyadh.
	 */
	public static function default_city() {
		return 'Riyadh';
	}

	/**
	 * Default state to Riyadh Province.
	 */
	public static function default_state() {
		return 'Riyadh Province';
	}

	/**
	 * Default postcode to 44000.
	 */
	public static function default_postcode() {
		return '44000';
	}

	/**
	 * Customize checkout fields to match Figma screens.
	 *
	 * @param array $fields Checkout fields.
	 * @return array Modified fields.
	 */
	public static function customize_checkout_fields( $fields ) {
		// Shipping fields
		if ( isset( $fields['shipping'] ) ) {
			if ( isset( $fields['shipping']['shipping_phone'] ) ) {
				$fields['shipping']['shipping_phone']['label']       = __( 'Shipping phone', 'spada-core' );
				$fields['shipping']['shipping_phone']['description'] = __( 'Only used for shipping-related questions.', 'spada-core' );
			}
			if ( isset( $fields['shipping']['shipping_address_1'] ) ) {
				$fields['shipping']['shipping_address_1']['placeholder'] = __( 'House number and street name', 'spada-core' );
			}
			if ( isset( $fields['shipping']['shipping_city'] ) ) {
				$fields['shipping']['shipping_city']['default'] = 'Riyadh';
			}
			if ( isset( $fields['shipping']['shipping_state'] ) ) {
				$fields['shipping']['shipping_state']['default'] = 'Riyadh Province';
			}
			if ( isset( $fields['shipping']['shipping_postcode'] ) ) {
				$fields['shipping']['shipping_postcode']['default'] = '44000';
			}
		}

		// Billing fields
		if ( isset( $fields['billing'] ) ) {
			if ( isset( $fields['billing']['billing_phone'] ) ) {
				$fields['billing']['billing_phone']['description'] = __( 'Only used for shipping-related questions.', 'spada-core' );
			}
			if ( isset( $fields['billing']['billing_address_1'] ) ) {
				$fields['billing']['billing_address_1']['placeholder'] = __( 'House number and street name', 'spada-core' );
			}
			if ( isset( $fields['billing']['billing_city'] ) ) {
				$fields['billing']['billing_city']['default'] = 'Riyadh';
			}
			if ( isset( $fields['billing']['billing_state'] ) ) {
				$fields['billing']['billing_state']['default'] = 'Riyadh Province';
			}
			if ( isset( $fields['billing']['billing_postcode'] ) ) {
				$fields['billing']['billing_postcode']['default'] = '44000';
			}
		}

		return $fields;
	}

	/**
	 * Output map helper prompt.
	 */
	public static function output_map_helper_prompt() {
		?>
		<div class="spada-map-helper-prompt">
			<span class="spada-prompt-icon" aria-hidden="true">📍</span>
			<span class="spada-prompt-text"><?php esc_html_e( 'If your exact address is not detected, move the red marker to your desired shipping address.', 'spada-core' ); ?></span>
		</div>
		<?php
	}

	/**
	 * Output free delivery promotion badge.
	 */
	public static function output_free_delivery_banner() {
		?>
		<div class="spada-free-delivery-banner" role="status">
			<span class="spada-check-icon" aria-hidden="true">✓</span>
			<span><?php esc_html_e( 'Free delivery on orders over SAR 250', 'spada-core' ); ?></span>
		</div>
		<?php
	}

	/**
	 * Output trust badges below Place Order button.
	 */
	public static function output_trust_badges() {
		static $displayed = false;
		if ( $displayed ) {
			return;
		}
		$displayed = true;
		include SPADA_CORE_PATH . 'templates/fluid-checkout/checkout-trust-badges.php';
	}

	/**
	 * Filter checkout page title.
	 *
	 * @param string $title Original title.
	 * @param string $step Current step identifier.
	 * @return string Filtered title.
	 */
	public static function filter_checkout_page_title( $title, $step = '' ) {
		if ( 'payment' === $step ) {
			return __( 'PAYMENT METHOD', 'spada-core' );
		}
		return __( 'CHECKOUT', 'spada-core' );
	}
}
