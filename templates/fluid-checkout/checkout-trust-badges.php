<?php
/**
 * SPADA Checkout Trust Badges
 *
 * Rendered below the Place Order button on Step 2.
 *
 * @package Spada
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="spada-checkout-trust-badges" aria-label="<?php esc_attr_e( 'Security and trust guarantees', 'spada-core' ); ?>">
	<div class="spada-trust-badge-item">
		<svg class="spada-trust-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
			<path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
		</svg>
		<span><?php esc_html_e( 'SSL secured', 'spada-core' ); ?></span>
	</div>
	<div class="spada-trust-badge-item">
		<svg class="spada-trust-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
		</svg>
		<span><?php esc_html_e( 'Data protected', 'spada-core' ); ?></span>
	</div>
	<div class="spada-trust-badge-item">
		<svg class="spada-trust-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
			<polyline points="20 6 9 17 4 12"></polyline>
		</svg>
		<span><?php esc_html_e( 'Easy returns', 'spada-core' ); ?></span>
	</div>
</div>
