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
		// Quick View
		initQuickView();

		// IE Grid Hover Event
		if($('.quick-view-enabled').length && $('html.ie').length && ($('#results .product-grid li').length || $('.product-grid-homepage').length || $('#results .product-list li').length)) {
			$('.product-grid li, .product-list li').hover(function() {
				$(this).addClass('hover');
			}, function() {
				$(this).removeClass('hover');
			});
		}
		
		$('.product-grid li, .product-list li').click(function(e) {
		    window.location.href = $(this).find('.grid-title a, .list-title a').attr('href');
		});

		if($('#results').length && $('#show-more-loader').length) {
			$('#results').catalogAjax({
				productlinkselector: '.item a', 
				maincolselector: '#results',
				contentheightselector: 'body',
				onPageLoaded: function() {
					initQuickView();
				}
			});	
		}
	});

	function initQuickView() {
		if($('.quick-view-enabled').length && ($('#results .product-grid li').length || $('.product-grid-homepage').length || $('#results .product-list li').length)) {
			$('.product-grid .grid-image, .product-list .list-image').unbind().hoverIntent({
				interval: 20,
				over: function() {
					$(this).find('.grid-quick-view, .list-quick-view').show();
				}, 
				out: function() {
					$(this).find('.grid-quick-view, .list-quick-view').hide();
				}
			});
			
			$('.product-grid .grid-image .grid-quick-view a, .product-list .list-image .list-quick-view a').unbind().one('click', function(e) {
				showQuickView(this, e);
				$(this).click(function() { return false; });
				e.preventDefault();
				e.stopPropagation();
			});
		}
	}

	function showQuickView(link, e) {
		var quickUrl = $(link).data('url');
		$('body').append('<div id="ajax-load"></div>');
		$('#ajax-load').center();

		$.getJSON(quickUrl, function(data) {
			$('#ajax-load').remove();
			$('body').append(data.html);
			$('.quick-view').lightbox_me({
				centered: true, 
				destroyOnClose: true,
				overlaySpeed: 10,
				onLoad: function() {
					$.each(data.scripts, function(i, script) {
						if($.trim(script)) {
							$.globalEval($.trim(script));
						}
					});
				},
				onClose: function() {
					$(link).one('click', function(e) { 
						showQuickView(link, e);
						$(this).click(function() { return false; });
					});
				}
			});
		});
		
		e.preventDefault();
	}
})(jQuery);