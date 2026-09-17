=== Spada Core ===
Converts Elementor/WooCommerce product-loop Buy Now buttons into a direct checkout flow. Simple products are added directly to cart. Variable products show a compact variation selector directly above the Buy Now button instead of a popup.

== Usage ==
1. Install and activate the plugin.
2. In Elementor, add the CSS class `spada-buy-now` to the custom Buy Now button.
3. Product IDs are detected automatically from the WooCommerce/Elementor loop.

== Variable Products ==
Variable products display a minimal selector above the Buy Now button. WooCommerce's variation matching is used, and Buy Now remains disabled until a valid, in-stock, purchasable variation is selected.

== Loading States ==
Buttons show a spinner while product data or cart actions are loading. The inline variation selector shows a loading indicator while variation options are fetched.

== Variation Pricing ==
When a variation is selected, the Buy Now button automatically updates to show that variation's current price.
