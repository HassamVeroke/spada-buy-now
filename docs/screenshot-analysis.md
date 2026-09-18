# SPADA Figma Screenshots Analysis

## Overview
This document provides a comprehensive visual and functional analysis of each screenshot export located in `SPADA Website Figma Screens/`. These screenshots serve as the visual source of truth for the SPADA WooCommerce Checkout and My Account experiences.

---

## Screenshot Inventory

### 1. `Checkout Step 1.png`
- **Represents**: Step 1 of Checkout (Shipping Address & Order Summary).
- **Page Header**:
  - Global navigation bar (black `#000000` background): Spada logo, links (`Home`, `Get Spada`, `Subscribe Now`, `About Us`, `B2B Partnerships`), action buttons (`Sign In`, `Cart (0)`), language switcher (`English ˅`).
  - Hero title: `"CHECKOUT"` in uppercase condensed display font (`Barlow Condensed` / `itf rayat` / `Bebas Neue`), ~48-56px, centered, dark `#000000`.
- **Top Notice Banner**:
  - Salmon/light pink background (`#fef2f2`), reddish border (`#fecaca`), rounded `8px`.
  - Icon: Red warning triangle ⚠️.
  - Text: `"Currently serving only in Riyadh, will expand soon."` in bold dark red (`#b91c1c`).
- **Layout**:
  - Two-column grid layout on desktop (~65% shipping address column, ~35% order summary column).
  - Collapses to single column stacked on tablet and mobile (< 1024px).
- **Left Column: Shipping Address Card**:
  - White container (`#ffffff`), rounded corners (`16px`), subtle border (`1px solid #e5e7eb`), padding `28px`.
  - Section title: `"SHIPPING ADDRESS"` (bold uppercase, letter spacing, font size `14px`, color `#111827`).
  - Fields:
    - **Full Name \***: Full-width text input, rounded `8px`, border `1px solid #0000004d`, padding `14px 18px`.
    - **Shipping phone \***: Text input, with subtext `"Only used for shipping-related questions."` in muted grey (`#6b7280`, `12px`).
    - **Country / Region \***: Readonly/dropdown with preset value `"Saudi Arabia"`.
    - **Street address \***: Full-width input with placeholder/label `"House number and street name"`.
    - **Town / City \*** and **State / County \***: Side-by-side (2 columns, 50% width each), prefilled with `"Riyadh"` and `"Riyadh Province"`.
    - **Postcode / ZIP \***: Text input prefilled with `"44000"`.
    - **Delivery Date \***: Date picker field for scheduled delivery.
  - Horizontal separator line (`#e5e7eb`).
  - Map prompt: 📍 `"If your exact address is not detected, move the red marker to your desired shipping address."` (`13px`, color `#4b5563`).
  - Interactive map container (Map Location Picker) with location search bar (`"Riyadh"`), layer switcher (`Satellite`, `Noir et Blanc`), zoom controls (`+`, `-`), and draggable location pin.
  - Primary button: `"Proceed to Checkout"` (full width, bright teal `#00adb5` / `#00a9bb`, white bold text, rounded `8px`, min-height `48px`).
- **Right Column: Order Summary Card**:
  - White container (`#ffffff`), rounded `16px`, border `1px solid #e5e7eb`, padding `24px`.
  - Header row: `"ORDER SUMMARY"` (bold `14px`, color `#111827`) + item count right-aligned (`"2 items"`, `#6b7280`).
  - Cart Item List:
    - Item 1: Thumbnail (~64x64px, rounded `8px`), Title `"Lemon Lime — 24 Pack"`, Unit/Pack info `"Qty: 24 Pack"` and `"﷼ 74.95"`, Subtotal `"﷼ 149.90"`.
      - Quantity stepper: `[-] 1 [+]` (pill/box with minus, quantity number, plus).
      - Delete action: Red outlined trash can button `🗑️`.
    - Item 2: Thumbnail, Title `"Classic Sparkling — 12 Pack"`, Unit/Pack info `"Qty: 12 Pack"` and `"﷼ 59.90"`, Subtotal `"﷼ 59.90"`, quantity stepper `[-] 1 [+]`, trash icon.
  - Action button: `+ Add More` (teal border, white background, `+` square icon, links to shop).
  - Totals table:
    - `"Total Price Excluding VAT"`: `﷼ 130.35`
    - `"Total VAT (15%)"`: `﷼ 19.55`
    - `"Subtotal"`: `﷼ 149.90`
    - `"Shipping"`: `—`
    - `+ Add coupon code`: Collapsible coupon link in teal.
    - `"TOTAL"` row: Light grey background box (`#f3f4f6`), rounded `6px`, padding `14px 18px`, bold uppercase label and price: `TOTAL` `﷼ 149.90`.

---

### 2. `Checkout Step 2.png`
- **Represents**: Step 2 of Checkout (Payment Method & Order Submission).
- **Page Header**:
  - Global navigation bar (consistent with Step 1).
  - Hero title: `"PAYMENT METHOD"` in uppercase condensed display font (~48-56px).
- **Top Notice Banner**:
  - Consistent Riyadh expansion warning banner.
- **Layout**:
  - Centered card container (~720px max-width) or single checkout column.
- **Payment Method Card**:
  - White container, rounded `16px`, border `1px solid #e5e7eb`, padding `28px`.
  - Header: `"PAYMENT METHOD"` (bold `14px` uppercase).
  - Section title: `"Card Payment"` (bold `18px`), subtitle: `"Pay with your Credit/Debit Card."` (`14px`, `#6b7280`).
  - Card fields:
    - **Cardholder Name \***: Full-width text input with placeholder `"Name on Card"`.
    - **Card Number \***: Full-width input with placeholder `"1234 5678 9101 1121"`.
    - **Expiry (MM/YY) \*** and **Card Code (CVC) \***: Side-by-side 2-column inputs (`"MM / YY"` and `"123"`).
    - Card brand badges: VISA, Mastercard, mada.
  - Alternative payment method options:
    - Radio option: `◯ Apple Pay` with Apple Pay icon right-aligned.
    - Radio option: `◯ STC Pay` with STC Pay icon right-aligned.
  - Privacy policy text:
    - `"Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our privacy policy."`
  - Terms checkbox:
    - `[ ] I have read and agree to the website terms and conditions *`
  - Free delivery notification pill:
    - Light mint green background (`#ecfdf5`), border `#d1fae5`, green checkmark `✓`, text: `"Free delivery on orders over SAR 250"`.
  - Submit button:
    - Full-width primary button `"Place Order"` (teal `#00adb5` / `#00a9bb`, white text, rounded `8px`, min-height `48px`).
  - Security footer:
    - Centered icons and labels: `🔒 SSL secured` &nbsp; `🛡️ Data protected` &nbsp; `✓ Easy returns` (muted `#6b7280`).

---

### 3. `My Account.png`
- **Represents**: Account Portal Landing Screen (Logged-out state).
- **Page Header**:
  - Global navigation bar.
  - Hero title: `"ACCOUNT"` in uppercase condensed font (~48-56px).
  - Subtitle: `"Please provide necessary details to access to your account."` (`15px`, `#4b5563`).
- **Main Portal Card**:
  - Centered white container (~680px width), rounded `24px`, subtle shadow/border, padding `48px 36px`.
  - Two choice cards displayed side-by-side with a vertical/horizontal divider with `"OR"` label:
    - **Left Card: "Signup"**:
      - Circular badge with user-plus icon `👤+`.
      - Label: `"Signup"` (font size `18px`, bold, `#111827`).
      - Border: `1px solid #e5e7eb`, white background.
    - **Right Card: "Login"**:
      - Circular badge with enter/arrow icon `🚪→`.
      - Label: `"Login"` (font size `18px`, bold, `#00adb5`).
      - Border: `1.5px solid #00adb5` (active/selected state).

---

### 4. `My Account Login-1.png`
- **Represents**: Login Method Selector Screen.
- **Page Header**:
  - Hero title: `"LOGIN"` in uppercase condensed font.
  - Subtitle: `"Please provide necessary details to login to your account."`
- **Inside Card**:
  - Title: `"Choose account"` (bold `22px`, `#111827`).
  - Subtitle: `"Please select any of the below to continue."` (`14px`, `#6b7280`).
  - Method buttons:
    1. **Sign in with Email**:
       - Left icon: Teal email envelope.
       - Label: `"Sign in with Email"`.
       - Active state: Teal border (`#00adb5`), rounded `8px`, padding `16px 20px`, text color `#00adb5`.
    2. **Sign in with Whatsapp**:
       - Left icon: WhatsApp icon.
       - Label: `"Sign in with Whatsapp"`.
       - Default state: Grey border (`#e5e7eb`), black text.
    3. **Sign in with SMS**:
       - Left icon: SMS chat bubble icon with dots.
       - Label: `"Sign in with SMS"`.
       - Default state: Grey border (`#e5e7eb`), black text.

---

### 5. `My Account Login-2.png`
- **Represents**: Email Address Entry Step.
- **Components**:
  - Top-left navigation: Back arrow button `←` to return to Method Selector.
  - Center top icon: Circular light teal container with teal email envelope.
  - Title: `"Enter your email address"` (bold `22px`).
  - Subtitle: `"We'll send a six digit code to your email adress."`
  - Input field: Label `"EMAIL ADDRESS"` in uppercase grey `11px`, full-width input box with soft background (`#f9fafb`), rounded `8px`.
  - Button: `"Continue"` (full width teal `#00adb5`).
  - Divider: Horizontal line with `"OR"` in center.
  - Secondary button: `"Choose another option"` (white background, teal border `#00adb5`, teal text).

---

### 6. `My Account Login-3.png`
- **Represents**: WhatsApp Number Entry Step.
- **Components**:
  - Top-left navigation: Back arrow `←`.
  - Center top icon: Circular light teal container with WhatsApp logo.
  - Title: `"Enter your whatsapp number"`.
  - Subtitle: `"We'll send a six digit code to your whatsapp"`.
  - Input field: Label `"WHATSAPP NUMBER"`, phone code selector (`+966`), number field.
  - Button: `"Continue"`.
  - Divider `"OR"`.
  - Secondary button: `"Choose another option"`.

---

### 7. `My Account Login-4.png`
- **Represents**: Mobile Number (SMS) Entry Step.
- **Components**:
  - Top-left navigation: Back arrow `←`.
  - Center top icon: Circular light teal container with SMS chat bubble.
  - Title: `"Enter your mobile number"`.
  - Subtitle: `"We'll send a six digit code to your mobile number"`.
  - Input field: Label `"MOBILE NUMBER"`, phone code selector (`+966`), number field.
  - Button: `"Continue"`.
  - Divider `"OR"`.
  - Secondary button: `"Choose another option"`.

---

### 8. `My Account Login-5.png`
- **Represents**: Email 6-Digit OTP Verification Step.
- **Components**:
  - Top-left navigation: Back arrow `←`.
  - Center top icon: Circular light teal container with teal email envelope.
  - Title: `"Check your email address"`.
  - Subtitle: `"We've sent a six digit code to your email adress"` + dynamic email address e.g. `"someone@example.com."`.
  - **OTP Input Boxes**:
    - Exactly 6 separate rectangular boxes (~48x54px each), rounded `8px`.
    - Teal border (`#00adb5`), large centered digits (`20px`, bold).
    - Supports auto-advance on keystroke, backspace navigation, paste of full 6-digit code, and mobile numeric keypad.
  - Button: `"Continue"` (full width teal `#00adb5`).
  - Resend prompt: `"Didn't receive the email? Click to resend"` (with dynamic countdown timer).
  - Secondary button: `"Change Email"` (white background, teal border, returns to email input step).

---

### 9. `My Account Login-6.png`
- **Represents**: WhatsApp 6-Digit OTP Verification Step.
- **Components**:
  - Top-left navigation: Back arrow `←`.
  - Center top icon: Circular container with WhatsApp logo.
  - Title: `"Check your whatsapp account"`.
  - Subtitle: `"We've sent a six digit code to your whatsapp account on"` + masked phone e.g. `"+966 *******911."`.
  - 6 separate OTP input boxes with teal border.
  - Button: `"Continue"`.
  - Resend prompt: `"Didn't receive the message on whatsapp? Click to resend"`.
  - Secondary button: `"Change Number"`.

---

### 10. `My Account Login-7.png`
- **Represents**: Mobile / SMS 6-Digit OTP Verification Step.
- **Components**:
  - Top-left navigation: Back arrow `←`.
  - Center top icon: Circular container with SMS chat bubble.
  - Title: `"Check your messages"`.
  - Subtitle: `"We've sent a six digit code to your mobile number"` + masked phone e.g. `"+966 *******911."`.
  - 6 separate OTP input boxes with teal border.
  - Button: `"Continue"`.
  - Resend prompt: `"Didn't receive the message on number? Click to resend"`.
  - Secondary button: `"Change Number"`.

---

## Typography, Palette & UI Design System

| Element | Value / Rule |
| :--- | :--- |
| **Primary Brand Color** | `#00adb5` / `#00a9bb` (Spada Teal) |
| **Secondary Dark** | `#111827` / `#1f2937` (Text headings and primary dark accents) |
| **Notice Alert Red** | `#fee2e2` (bg), `#b91c1c` (text), `#fca5a5` (border) |
| **Badge Mint Green** | `#ecfdf5` (bg), `#059669` (text), `#d1fae5` (border) |
| **Background Neutral** | `#f9fafb` (inputs, cards background), `#ffffff` (card surface) |
| **Border Neutral** | `#e5e7eb` / `#0000001a` |
| **Display Font Family** | `'itf rayat'`, `'Bebas Neue'`, `'Barlow Condensed'`, sans-serif |
| **Body Font Family** | `'itf rayat'`, `'Inter'`, system-ui, -apple-system, sans-serif |
| **Corner Radius** | Inputs & Buttons: `8px`; Cards: `16px`; Account Portal: `24px` |
