/**
 * SPADA Fluid Checkout JavaScript Handler
 *
 * Manages dynamic AJAX DOM lifecycle, quantity stepper interactions,
 * and delivery date coordination.
 */

(function($) {
	'use strict';

	var SpadaFC = {
		init: function() {
			this.bindEvents();
			this.initQuantitySteppers();
			this.initDeliveryDateFailsafe();
		},

		bindEvents: function() {
			var self = this;

			// Re-attach handlers when WooCommerce or Fluid Checkout reloads checkout fragments
			$(document.body).on('updated_checkout fc_step_loaded fc_checkout_updated', function() {
				self.initQuantitySteppers();
				self.initDeliveryDateFailsafe();
			});

			// Quantity plus/minus stepper delegation
			$(document).on('click', '.fc-wrapper .qty-plus, .fc-wrapper .qty-minus', function(e) {
				e.preventDefault();
				var $btn = $(this);
				var $qtyInput = $btn.closest('.quantity').find('input.qty');

				if (!$qtyInput.length) {
					return;
				}

				var currentVal = parseFloat($qtyInput.val()) || 1;
				var min = parseFloat($qtyInput.attr('min')) || 1;
				var max = parseFloat($qtyInput.attr('max')) || 999;
				var step = parseFloat($qtyInput.attr('step')) || 1;

				if ($btn.hasClass('qty-plus')) {
					if (currentVal + step <= max) {
						$qtyInput.val(currentVal + step).trigger('change');
					}
				} else if ($btn.hasClass('qty-minus')) {
					if (currentVal - step >= min) {
						$qtyInput.val(currentVal - step).trigger('change');
					}
				}
			});
		},

		initQuantitySteppers: function() {
			$('.fc-wrapper .quantity').each(function() {
				var $qtyWrap = $(this);
				if (!$qtyWrap.find('.qty-plus').length) {
					$qtyWrap.prepend('<button type="button" class="qty-minus" aria-label="Decrease quantity">−</button>');
					$qtyWrap.append('<button type="button" class="qty-plus" aria-label="Increase quantity">+</button>');
				}
			});
		},

		initDeliveryDateFailsafe: function() {
			var inputField = document.getElementById('coderockz_woo_delivery_date_datepicker');
			if (!inputField || !inputField._flatpickr) {
				return;
			}

			// Figure out the next valid date (skip weekends if applicable)
			if (inputField.value.trim() === '') {
				var d = new Date();
				d.setDate(d.getDate() + 1);
				while (d.getDay() === 5 || d.getDay() === 6) { // Friday & Saturday in KSA
					d.setDate(d.getDate() + 1);
				}
				inputField._flatpickr.setDate(d, true);
			}
		}
	};

	$(document).ready(function() {
		SpadaFC.init();
	});

})(jQuery);
