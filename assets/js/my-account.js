/**
 * SPADA My Account Client Script
 */

(function($) {
	'use strict';

	$(document).ready(function() {
		// Highlight active navigation tab if not automatically flagged
		var currentPath = window.location.pathname;
		$('.woocommerce-MyAccount-navigation li a').each(function() {
			if ($(this).attr('href') && currentPath.indexOf($(this).attr('href')) !== -1) {
				$(this).closest('li').addClass('is-active');
			}
		});
	});

})(jQuery);
