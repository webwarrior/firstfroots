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
	$('.product-list li').bind('tap click', function() {
		window.location.href = $(this).find('.list-title a').attr('href');
	});

	$('#sort-button').click(function(e) {
		$('#search-box input').trigger('focus');
		e.preventDefault();
	});

	$('#filter-button').click(function(e) {
		if($('#filter-container').length) {
			var filterMenu = $('#filter-container').html();
			$('#filter-container').remove();
			$('body').append(filterMenu);	
		}

		$('.lb-overlay .close-button').unbind().click(function(e) {
			$('.lb-overlay').removeClass('active').css({ 'width': 0, 'height': 0 });
			e.preventDefault();
		});

		$('.lb-overlay').addClass('active').width($('body').width()).height($('body').height()).unbind().click(function(e) {
			if($(e.target).hasClass('lb-overlay')) {
				$('.lb-overlay').removeClass('active').css({ 'width': 0, 'height': 0 });
			}
			e.preventDefault();
		});

		e.preventDefault();
	});

	// Remove filter button if no filters available
	if(!$('#filter-container').length) {
		$('#filter-button').remove();
	}
})(Zepto);