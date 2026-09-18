# Mobile Login WooCommerce Integration

## Overview
This document outlines how SPADA integrates with and extends `mobile-login-woocommerce` to provide phone-based (SMS and WhatsApp) authentication alongside custom email OTP verification.

## Supported Authentication Channels
1. **SMS OTP**:
   - Sent via Mobile Login WooCommerce's active SMS operator (e.g. Unifonic / Twilio / Msegat).
   - Utilizes `xoo_ml_request_otp` and `xoo_ml_otp_form_submit` actions.
2. **WhatsApp OTP**:
   - Routed through Mobile Login's WhatsApp service (`class-xoo-ml-service-whatsapp.php`).
   - Triggered when the user selects "Sign in with Whatsapp".
3. **Email OTP**:
   - Managed server-side via `Spada_OTP_Email` within `Spada Core`.
   - Generates a cryptographically secure 6-digit integer.
   - Dispatches via WordPress `wp_mail()` with branded HTML.
   - Verified via server-side transient comparison with attempt throttling.

## UI & State Transitions
- Step 1: Method Selector (`Email`, `WhatsApp`, `SMS`).
- Step 2: Destination Input (`Email Address`, `WhatsApp Number`, or `Mobile Number`).
- Step 3: 6-Digit OTP Verification:
  - 6 separate input boxes.
  - Auto-advance on input.
  - Auto-backspace to previous input.
  - Clipboard paste auto-fill.
  - Resend countdown timer (60 seconds).
  - "Change Email" / "Change Number" navigation.

## Authoritative Session Initialization
Upon successful OTP confirmation:
```php
wp_clear_auth_cookie();
wp_set_current_user( $user->ID );
wp_set_auth_cookie( $user->ID, true );
do_action( 'wp_login', $user->user_login, $user );
```
In checkout context, triggers `$(document.body).trigger('update_checkout')` so customer shipping, billing, and address fields update without a full page reload.
