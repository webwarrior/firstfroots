/**
 * Avalanche Mobile for Magento 1.6+
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
 * @version    1.0.0
 * @copyright  Copyright 2012 Fast Division
 * @license    http://fastdivision.com/legal/license.txt
 */
(function($) {
	$('.quantity-dropdown').change(function() {
		$('#shopping-cart-form').submit();
	});

	$('#items-in-cart .item-details td').swipeLeft(function() {
		var removeText = $('#remove-text').text();
		if(confirm(removeText + ' ' + $(this).closest('tr').find('.item-desc a').text() + '?')) {
			document.location.href = $(this).closest('tr').next().find('.low-button').attr('href');
		}
	}).swipeRight(function() {
		var removeText = $('#remove-text').text();
		if(confirm(removeText + ' ' + $(this).closest('tr').find('.item-desc a').text() + '?')) {
			document.location.href = $(this).closest('tr').next().find('.low-button').attr('href');
		}
	});
})(Zepto);