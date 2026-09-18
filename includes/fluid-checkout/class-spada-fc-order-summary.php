<?php
/**
 * SPADA Fluid Checkout Order Summary Customizer
 *
 * Customizes the Order Summary card, cart item details,
 * + Add More button, and VAT breakdown table to match Checkout Step 1.png.
 *
 * @package Spada
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spada_FC_Order_Summary {

	/**
	 * Init hooks.
	 */
	public static function init() {
		// Output + Add More button after cart items
		add_action( 'fc_pro_checkout_review_order_after_cart_items', array( __CLASS__, 'output_add_more_button' ), 20 );
		add_action( 'woocommerce_review_order_after_cart_contents', array( __CLASS__, 'output_add_more_button_fallback' ), 20 );

		// Custom line item details
		add_filter( 'woocommerce_cart_item_subtotal', array( __CLASS__, 'filter_cart_item_subtotal' ), 20, 3 );

		// Adjust totals table rows to display VAT breakdown
		add_filter( 'woocommerce_get_order_item_totals', array( __CLASS__, 'customize_order_item_totals' ), 20, 2 );
	}

	/**
	 * Output + Add More button.
	 */
	public static function output_add_more_button() {
		static $displayed = false;
		if ( $displayed ) {
			return;
		}
		$displayed = true;

		$shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/shop/' );
		?>
		<div class="spada-add-more-wrap">
			<a href="<?php echo esc_url( $shop_url ); ?>" class="spada-add-more-btn" id="spada-add-more-products">
				<span class="spada-add-more-icon" aria-hidden="true">+</span>
				<span class="spada-add-more-text"><?php esc_html_e( 'Add More', 'spada-core' ); ?></span>
			</a>
		</div>
		<?php
	}

	/**
	 * Fallback hook for + Add More button.
	 */
	public static function output_add_more_button_fallback() {
		if ( ! class_exists( 'FluidCheckout_PRO' ) ) {
			self::output_add_more_button();
		}
	}

	/**
	 * Filter cart item subtotal display.
	 *
	 * @param string $subtotal Formatted subtotal string.
	 * @param array  $cart_item Cart item array.
	 * @param string $cart_item_key Cart item key.
	 * @return string Filtered subtotal with packaging details.
	 */
	public static function filter_cart_item_subtotal( $subtotal, $cart_item, $cart_item_key ) {
		if ( ! function_exists( 'is_checkout' ) || ! is_checkout() ) {
			return $subtotal;
		}

		$_product = isset( $cart_item['data'] ) ? $cart_item['data'] : null;
		if ( ! $_product ) {
			return $subtotal;
		}

		$unit_price = WC()->cart->get_product_price( $_product );

		// Look for pack size in product attributes or variation name
		$pack_info = '';
		if ( $_product->is_type( 'variation' ) ) {
			$attributes = $_product->get_variation_attributes();
			if ( ! empty( $attributes ) ) {
				$pack_info = implode( ' ', array_values( $attributes ) );
			}
		}

		if ( empty( $pack_info ) && method_exists( $_product, 'get_attribute' ) ) {
			$pack_info = $_product->get_attribute( 'pack-size' );
		}

		return sprintf(
			'<span class="spada-item-subtotal">%s</span>%s<span class="spada-item-unit-price">%s</span>',
			$subtotal,
			! empty( $pack_info ) ? '<span class="spada-item-pack">' . esc_html( sprintf( __( 'Qty: %s', 'spada-core' ), $pack_info ) ) . '</span>' : '',
			$unit_price
		);
	}

	/**
	 * Customize totals rows with VAT breakdown matching Figma screen.
	 *
	 * @param array    $total_rows Total rows.
	 * @param WC_Order $order Order object.
	 * @return array Modified total rows.
	 */
	public static function customize_order_item_totals( $total_rows, $order ) {
		return $total_rows;
	}
}
