/**
 * Avalanche for Magento 1.6+
 * Designed by Fast Division (http://fastdivision.com)
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://fastdivision.com/legal/license.txt
 *
 * @author     Fast Division
 * @version    1.3.0
 * @copyright  Copyright 2012 Fast Division
 * @license    http://fastdivision.com/legal/license.txt
 */
(function($) {
	$(document).ready(function() {
		if($('#shopping-cart-form').length) {
			var updateQuantityPost = $('#shopping-cart-form').attr('action');
			var discountPost = $('.discount').metadata({ name: 'data', type: 'attr' }).post;
		}

		$('#update-quantity-button').click(function(e) {
			$('#shopping-cart-form').attr('action', updateQuantityPost).submit();
			e.preventDefault();
		});

		// Discount button needs to use #shopping-cart-form, can't nest forms
		$('#apply-discount-button').click(function(e) {
			$('#coupon_code').addClass('required-entry');
	        $('#remove-coupone').attr('value', 0);
			$('#shopping-cart-form').attr('action', discountPost).submit();
			e.preventDefault();
		});
		$('#cancel-discount-button').click(function(e) {
			$('#coupon_code').removeClass('required-entry');
	        $('#remove-coupone').attr('value', 1);
			$('#shopping-cart-form').attr('action', discountPost).submit();
			e.preventDefault();
		});
	});
})(jQuery);