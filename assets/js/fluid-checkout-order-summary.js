/**
 * SPADA Fluid Checkout Order Summary Interactions
 *
 * Handles quantity stepper, item removal, and inline coupon codes with WooCommerce AJAX sync.
 */

(function($) {
	'use strict';

	var SpadaOrderSummary = {
		init: function() {
			this.bindEvents();
		},

		bindEvents: function() {
			var self = this;

			// Quantity Stepper Click
			$(document).on('click', '.spada-qty-btn', function(e) {
				e.preventDefault();
				self.handleQuantityChange($(this));
			});

			// Item Removal Click
			$(document).on('click', '.spada-remove-btn', function(e) {
				e.preventDefault();
				self.handleRemoveItem($(this));
			});

			// Toggle Coupon Form
			$(document).on('click', '#spada-toggle-coupon-btn', function(e) {
				e.preventDefault();
				var $form = $('#spada-inline-coupon-form');
				$form.toggleClass('is-hidden');
				if (!$form.hasClass('is-hidden')) {
					$('#spada_coupon_code').focus();
				}
			});

			// Apply Coupon Code
			$(document).on('click', '#spada_apply_coupon_btn', function(e) {
				e.preventDefault();
				self.handleApplyCoupon();
			});

			$(document).on('keypress', '#spada_coupon_code', function(e) {
				if (e.which === 13) {
					e.preventDefault();
					self.handleApplyCoupon();
				}
			});
		},

		handleQuantityChange: function($btn) {
			var action = $btn.data('action');
			var cartKey = $btn.data('cart_item_key');
			var $input = $btn.siblings('.spada-qty-input');
			var currentVal = parseInt($input.val(), 10) || 1;
			var maxVal = parseInt($input.attr('max'), 10);
			var newVal = currentVal;

			if (action === 'decrease') {
				if (currentVal > 1) {
					newVal = currentVal - 1;
				} else {
					return;
				}
			} else if (action === 'increase') {
				if (!maxVal || currentVal < maxVal) {
					newVal = currentVal + 1;
				} else {
					return;
				}
			}

			$input.val(newVal);
			this.updateQuantityAjax(cartKey, newVal);
		},

		updateQuantityAjax: function(cartKey, qty) {
			var $table = $('.spada-order-summary-table');
			$table.addClass('is-loading');

			$.ajax({
				url: SpadaFCOrderSummary.ajaxUrl,
				type: 'POST',
				data: {
					action: 'spada_fc_update_cart_qty',
					security: SpadaFCOrderSummary.nonce,
					cart_item_key: cartKey,
					quantity: qty
				},
				success: function(response) {
					// Refresh WooCommerce checkout fragments
					$(document.body).trigger('update_checkout');
				},
				error: function() {
					$table.removeClass('is-loading');
				}
			});
		},

		handleRemoveItem: function($btn) {
			var cartKey = $btn.data('cart_item_key');
			var $table = $('.spada-order-summary-table');
			$table.addClass('is-loading');

			$.ajax({
				url: SpadaFCOrderSummary.ajaxUrl,
				type: 'POST',
				data: {
					action: 'spada_fc_remove_cart_item',
					security: SpadaFCOrderSummary.nonce,
					cart_item_key: cartKey
				},
				success: function(response) {
					// Refresh WooCommerce checkout fragments
					$(document.body).trigger('update_checkout');
				},
				error: function() {
					$table.removeClass('is-loading');
				}
			});
		},

		handleApplyCoupon: function() {
			var $input = $('#spada_coupon_code');
			var code = $.trim($input.val());
			var $msg = $('#spada-coupon-msg');

			if (!code) {
				$msg.text(SpadaFCOrderSummary.couponEmpty).removeClass('is-hidden is-success').addClass('is-error');
				return;
			}

			var $table = $('.spada-order-summary-table');
			$table.addClass('is-loading');

			$.ajax({
				url: SpadaFCOrderSummary.ajaxUrl,
				type: 'POST',
				data: {
					action: 'spada_fc_apply_coupon',
					security: SpadaFCOrderSummary.nonce,
					coupon_code: code
				},
				success: function(response) {
					if (response.success) {
						$msg.text(response.data.message).removeClass('is-hidden is-error').addClass('is-success');
						$input.val('');
						$(document.body).trigger('update_checkout');
					} else {
						$table.removeClass('is-loading');
						$msg.text(response.data.message).removeClass('is-hidden is-success').addClass('is-error');
					}
				},
				error: function() {
					$table.removeClass('is-loading');
				}
			});
		}
	};

	$(document).ready(function() {
		SpadaOrderSummary.init();
	});

})(jQuery);
