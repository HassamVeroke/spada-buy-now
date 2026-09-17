<?php
/**
 * Plugin Name: Spada Core
 * Plugin URI: https://www.veroke.com/
 * Description: Adds a Buy Now workflow to Elementor/WooCommerce product-loop buttons. Simple products go directly to checkout; variable products open a variation selector first.
 * Version: 1.6.8
 * Author: Veroke
 * Author URI: https://www.veroke.com/
 * Text Domain: spada-buy-now
 * Requires Plugins: woocommerce
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SPADA_BUY_NOW_VERSION', '1.6.8' );
define( 'SPADA_BUY_NOW_FILE', __FILE__ );
define( 'SPADA_BUY_NOW_URL', plugin_dir_url( __FILE__ ) );
define( 'SPADA_BUY_NOW_PATH', plugin_dir_path( __FILE__ ) );

require_once SPADA_BUY_NOW_PATH . 'includes/class-spada-buy-now.php';

Spada_Buy_Now::instance();
