# SPADA My Account Customization

## Overview
This document specifies the My Account architecture and user experience matching `My Account.png` and `My Account Login-1.png` through `Login-7.png`.

## Logged-Out Experience
When an unauthenticated customer navigates to `/my-account/`:
1. The standard unstyled WooCommerce login form is replaced with the SPADA Account Portal (`account-portal.php`).
2. The customer is presented with two side-by-side selection cards:
   - **Signup**
   - **Login** (Highlighted with active teal border)
3. Selecting Login opens the Method Selection card (`Sign in with Email`, `Sign in with Whatsapp`, `Sign in with SMS`).
4. Step transitions proceed without page reloads using client-side state transitions backed by authoritative server AJAX endpoints.

## Logged-In Experience
When authenticated:
1. Navigation items are filtered via `woocommerce_account_menu_items`.
2. Dashboard, orders list, addresses, and account details are styled with modern Spada design tokens:
   - Rounded cards (`16px`).
   - Clean data tables with uppercase headers.
   - Status badges for orders (`Completed`, `Processing`, `Cancelled`).
   - Direct view order actions and reorder capabilities.
   - All customer data is retrieved strictly via official WooCommerce APIs (`wc_get_orders()`, `wp_get_current_user()`).
