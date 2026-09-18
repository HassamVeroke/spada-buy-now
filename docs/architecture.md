# SPADA Architecture & Integration Overview

## Architectural Principle
The SPADA checkout and customer account architecture follows a strict non-invasive model. Third-party core and plugin source codes are never directly modified. All customizations, UI layers, hooks, extensions, and asset enqueues are owned by the custom plugin **`Spada Core`** (`spada-core`).

```text
                      SPADA SCREENSHOTS
                             │
                             ▼
                   Visual Source of Truth
                             │
                             ▼
         ┌───────────────────────────────────────┐
         │ Existing WordPress & WooCommerce Core │
         │                                       │
         │ - WooCommerce 9.x                     │
         │ - Fluid Checkout & Fluid Checkout Pro │
         │ - Mobile Login WooCommerce            │
         │ - Map Location Picker Pro             │
         └───────────────────┬───────────────────┘
                             │
                  Hooks / Filters / APIs /
                 AJAX Handlers / Nonces
                             │
                             ▼
         ┌───────────────────────────────────────┐
         │ EXISTING CUSTOM PLUGIN                │
         │ (Spada Core / spada-core)             │
         │                                       │
         │ ├── includes/                         │
         │ │   ├── fluid-checkout/               │
         │ │   ├── authentication/               │
         │ │   ├── mobile-login/                 │
         │ │   └── my-account/                   │
         │ ├── templates/                        │
         │ └── assets/ (css & js)                │
         └───────────────────────────────────────┘
```

## Security Model
1. **No Client-Side OTP Storage**: One-Time Passwords are never returned in AJAX responses, stored in `localStorage`, or rendered in DOM attributes.
2. **Server-Side Authoritative Verification**: OTP codes are generated securely, stored in server-side transients with cryptographic hashes, limited to 5-minute lifetimes, and invalidated immediately upon first successful use or repeated failures (max 5 attempts).
3. **Nonce Protection & Validation**: All AJAX operations strictly require valid WordPress nonces (`wp_create_nonce` / `check_ajax_referer`) and input sanitization (`sanitize_email`, `sanitize_text_field`, `absint`).
4. **Authoritative Session Initialization**: User sessions are established using `wp_set_current_user()`, `wp_set_auth_cookie()`, and WooCommerce session handlers.

## Performance & Scoping
- Assets (`fluid-checkout.css`, `fluid-checkout.js`) are enqueued exclusively on checkout endpoints (`is_checkout() && ! is_order_received_page()`).
- My Account assets (`my-account.css`, `authentication.css`, `authentication.js`) are enqueued exclusively on account endpoints (`is_account_page()`) or where the authentication modal is rendered.
- Global Elementor pages, shop loops, and product single pages remain completely unaffected.
