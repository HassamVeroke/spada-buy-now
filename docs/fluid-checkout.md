# Fluid Checkout Pro Integration & Customization

## Overview
This document details the customization of Fluid Checkout Pro for SPADA according to `Checkout Step 1.png` and `Checkout Step 2.png`.

## Step Structure
- **Step 1: Shipping Address & Order Review**:
  - Shipping fields form with Riyadh prefilled.
  - Map Location Picker embedded under shipping address.
  - Order Summary sidebar containing editable quantities (`[-] 1 [+]`), trash delete buttons, and "+ Add More" shop redirect button.
  - Primary button: `"Proceed to Checkout"`.
- **Step 2: Payment Method**:
  - Payment gateway selection (Card Payment, Apple Pay, STC Pay).
  - Terms & conditions checkbox.
  - Free delivery promotion badge (`SAR 250+`).
  - Primary button: `"Place Order"`.
  - Trust badges footer (`🔒 SSL secured`, `🛡️ Data protected`, `✓ Easy returns`).

## Key Hooks & Filters Used

### 1. Header & Page Title
- `fc_checkout_page_title`: Filters the title to uppercase condensed styling `"CHECKOUT"` on step 1 and `"PAYMENT METHOD"` on step 2.

### 2. Notice Banner
- `fc_checkout_before` / `woocommerce_before_checkout_form`: Injects the top banner:
  ```html
  <div class="spada-checkout-alert">
      <span class="spada-alert-icon">⚠️</span>
      <span class="spada-alert-text">Currently serving only in Riyadh, will expand soon.</span>
  </div>
  ```

### 3. Order Summary & Cart Items
- `fc_pro_checkout_review_order_after_cart_items`: Outputs the `+ Add More` catalog link button.
- `woocommerce_cart_item_subtotal`: Displays formatted line item totals.
- `fc_order_summary_cart_item_details`: Renders pack quantity and unit pricing.

### 4. Trust Badges
- `woocommerce_review_order_after_submit`: Renders the trust badges container immediately beneath the place order button:
  ```html
  <div class="spada-checkout-trust-badges">
      <span>🔒 SSL secured</span>
      <span>🛡️ Data protected</span>
      <span>✓ Easy returns</span>
  </div>
  ```

### 5. Delivery Promo
- `woocommerce_review_order_before_submit`: Displays the mint green promotion bar:
  ```html
  <div class="spada-free-delivery-banner">
      ✓ Free delivery on orders over SAR 250
  </div>
  ```

## AJAX Compatibility
WooCommerce and Fluid Checkout dynamically replace `.woocommerce-checkout-review-order-table` and step containers during checkout recalculations. All event listeners in `assets/js/fluid-checkout.js` attach via event delegation (`$(document).on(...)`) to `updated_checkout` and `fc_step_loaded` events, preventing stale closures or detached element references.
