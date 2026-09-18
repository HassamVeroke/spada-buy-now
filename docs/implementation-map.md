# SPADA Implementation Map

## Overview
This document maps every major visual and interactive component shown in the Figma screenshots to its corresponding WooCommerce / Fluid Checkout / Mobile Login hook, filter, template, API, and custom plugin implementation file.

---

## 1. Checkout Step 1: Shipping Address & Order Summary

| Screenshot Component | WooCommerce / Fluid Checkout / Plugin Component | Hook / Filter / API | Custom Plugin File |
| :--- | :--- | :--- | :--- |
| **Notice Banner** (*"Currently serving only in Riyadh..."*) | Fluid Checkout / WooCommerce Notices | `fc_checkout_before`, `woocommerce_before_checkout_form` | `includes/fluid-checkout/class-spada-fc.php` |
| **Page Title** (`"CHECKOUT"`) | Fluid Checkout page title | `fc_display_checkout_page_title`, `fc_checkout_page_title` | `includes/fluid-checkout/class-spada-fc.php`, `assets/css/fluid-checkout.css` |
| **Shipping Address Card** | Fluid Checkout Shipping Step | `fc_checkout_step_shipping_fields_before`, `fc_substep_shipping_address_fields` | `includes/fluid-checkout/class-spada-fc.php` |
| **Full Name & Phone Fields** | WooCommerce checkout billing/shipping fields | `woocommerce_checkout_fields` | `includes/fluid-checkout/class-spada-fc.php` |
| **Riyadh City & Province Prefill/Lock** | WooCommerce checkout field defaults & attributes | `woocommerce_checkout_fields`, `default_checkout_billing_city` | `includes/fluid-checkout/class-spada-fc.php` |
| **Delivery Date Picker** | Flatpickr / Coderockz Delivery Date integration | `woocommerce_after_checkout_shipping_form` | `includes/fluid-checkout/class-spada-fc.php`, `assets/js/fluid-checkout.js` |
| **Map Location Picker Container** | `map-location-picker-at-checkout-for-woocommerce-pro` | `lpac_location_picker_checkout_action`, `woocommerce_after_checkout_shipping_form` | `includes/fluid-checkout/class-spada-fc.php`, `assets/css/fluid-checkout.css` |
| **Order Summary Card** | Fluid Checkout Pro Order Summary | `fc_pro_checkout_order_summary_before_cart_items`, `woocommerce_checkout_order_review` | `includes/fluid-checkout/class-spada-fc-order-summary.php` |
| **Cart Item Quantity Stepper `[-] 1 [+]`** | Fluid Checkout Pro Cart Item Quantity Field | `fc_order_summary_cart_item_details`, `fc_pro_cart_item_quantity_input` | `includes/fluid-checkout/class-spada-fc-order-summary.php`, `assets/js/fluid-checkout.js` |
| **Cart Item Trash/Remove Button** | Fluid Checkout Pro Cart Item Actions | `fc_pro_cart_item_actions`, `fc_order_summary_cart_item_details` | `includes/fluid-checkout/class-spada-fc-order-summary.php`, `assets/css/fluid-checkout.css` |
| **"+ Add More" Button** | Custom Spada Order Summary Catalog Link | `fc_pro_checkout_review_order_after_cart_items` | `includes/fluid-checkout/class-spada-fc-order-summary.php` |
| **VAT Totals Breakdown (15%)** | WooCommerce Cart Totals / Tax Breakdown | `woocommerce_get_order_item_totals`, `fc_pro_checkout_review_order_totals` | `includes/fluid-checkout/class-spada-fc-order-summary.php` |
| **Coupon Code Toggle Link** | Fluid Checkout Coupon Form | `fc_checkout_coupon_code_form` | `includes/fluid-checkout/class-spada-fc-order-summary.php`, `assets/css/fluid-checkout.css` |

---

## 2. Checkout Step 2: Payment Method

| Screenshot Component | WooCommerce / Fluid Checkout Component | Hook / Filter / API | Custom Plugin File |
| :--- | :--- | :--- | :--- |
| **Page Title** (`"PAYMENT METHOD"`) | Fluid Checkout page title / step heading | `fc_checkout_payment_step_title` | `includes/fluid-checkout/class-spada-fc.php` |
| **Card Payment Form** | WooCommerce Payment Gateways (e.g., Telr / Tap / Checkout.com / Stripe) | `woocommerce_review_order_before_payment`, `woocommerce_payment_gateways` | `includes/fluid-checkout/class-spada-fc.php`, `assets/css/fluid-checkout.css` |
| **Card Brand Badges** (VISA, Mastercard, mada) | Payment Gateway Icons Filter | `woocommerce_gateway_icon` | `includes/fluid-checkout/class-spada-fc.php` |
| **Alternative Payment Radios** (Apple Pay, STC Pay) | Available Gateways List | `woocommerce_available_payment_gateways` | `includes/fluid-checkout/class-spada-fc.php` |
| **Free Delivery Promo Banner** | Cart Totals / Delivery Notice Filter | `woocommerce_review_order_before_submit` | `includes/fluid-checkout/class-spada-fc.php` |
| **Place Order Primary Button** | Fluid Checkout Place Order Button | `fc_place_order_button_html`, `woocommerce_order_button_html` | `includes/fluid-checkout/class-spada-fc.php` |
| **Trust Badges** (*"🔒 SSL secured", "🛡️ Data protected", "✓ Easy returns"*) | Place Order Sub-content Hook | `woocommerce_review_order_after_submit`, `fc_checkout_after_place_order` | `templates/fluid-checkout/checkout-trust-badges.php`, `includes/fluid-checkout/class-spada-fc.php` |

---

## 3. My Account & Authentication Flow

| Screenshot Component | WooCommerce / Mobile Login Component | Hook / Filter / API / AJAX | Custom Plugin File |
| :--- | :--- | :--- | :--- |
| **Account Landing** (Signup vs Login cards) | WooCommerce Logged-Out Customer Template | `woocommerce_before_customer_login_form`, `template_include` | `templates/authentication/account-portal.php`, `includes/authentication/class-spada-auth.php` |
| **Method Selector** (Email, WhatsApp, SMS) | Custom Spada Auth State Controller | `templates/authentication/method-selector.php` | `includes/authentication/class-spada-auth.php` |
| **Identifier Inputs** (Email / Phone) | Input Screen Template & Validation | `templates/authentication/input-step.php` | `includes/authentication/class-spada-auth.php`, `assets/js/authentication.js` |
| **6-Digit OTP Verification Form** | OTP Input Matrix & State Controller | `templates/authentication/verify-step.php` | `includes/authentication/class-spada-auth.php`, `assets/js/authentication.js` |
| **SMS OTP Request & Verification** | Mobile Login WooCommerce Engine | `xoo_ml_request_otp`, `xoo_ml_otp_form_submit` | `includes/mobile-login/class-spada-mobile-login.php` |
| **WhatsApp OTP Delivery & Verification** | Mobile Login WooCommerce WhatsApp Service | `xoo_ml_services()->get_whatsapp_service()` | `includes/mobile-login/class-spada-mobile-login.php` |
| **Email OTP Generator & Verifier** | Authoritative Server-Side Transients & Mailer | `wp_ajax_spada_request_email_otp`, `wp_ajax_spada_verify_email_otp` | `includes/authentication/class-spada-otp-email.php`, `includes/authentication/class-spada-auth-ajax.php` |
| **User Login & Session Initialization** | WordPress & WooCommerce Auth APIs | `wp_set_current_user()`, `wp_set_auth_cookie()`, `wc_set_customer_auth_cookie()` | `includes/authentication/class-spada-auth-ajax.php` |
| **Customer Registration On-The-Fly** | WooCommerce Customer Creation API | `wc_create_new_customer()` | `includes/authentication/class-spada-auth-ajax.php` |
| **My Account Dashboard & Navigation** | WooCommerce Account Endpoints & Menus | `woocommerce_account_menu_items`, `woocommerce_account_content` | `includes/my-account/class-spada-my-account.php`, `assets/css/my-account.css` |
