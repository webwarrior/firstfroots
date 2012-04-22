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
		
		// Dropdown Menus: Only Activate for Mega + Suckerfish + Simple
		if(!$('#main-menu .no-dropdowns').length) {
			var menuSelector = "#main-menu ul > .level0";
			if($('#main-menu .suckerfish-dropdowns').length) // Suckerfish
				menuSelector = "#main-menu ul li";
			$(menuSelector).hoverIntent({
				interval: 20,
				over: function() { 
					$(this).addClass('droplink-active').children('.dropdown').addClass('dropdown-active');
				}, 
				out: function() {
					$(this).removeClass('droplink-active').children('.dropdown').removeClass('dropdown-active');
				}
			});
		}
			
		// jQuery Default Value HTML5 Placeholder Fallback
		$('[placeholder]').defaultValue();
		
		// Search Focus
		$('#search input').focus(function() { $(this).addClass('focus'); $('#search').addClass('focus'); })
							.blur(function() { $(this).removeClass('focus'); $('#search').removeClass('focus'); });
		
		// Back to Top Button
		$('.top').click(function(e) {
			$('html, body').animate({ 'scrollTop': $('#logo').scrollTop() }, 500);
			e.preventDefault();
		});
		$.waypoints.settings.scrollThrottle = 30;
		$('#wrapper').waypoint(function(event, direction) {
			$('.top').toggleClass('hideTop', direction === "up");
		});
		
		// Homepage Features (IE6-8)
		if($('.ie .features').length) {
			$('.ie .features .feature').last().addClass('last-feature');
		}
		
		// Quick Cart
		initQuickCart();
		
		// Slideshow
		if($('.slideshow').length) {
			var slideshowPlay = ($('.slideshow').data('autoplay')) ? Math.round($('.slideshow').data('autoplay') * 1000) : 0;
			var slideshowEffect = ($('.slideshow').data('effect')) ? $('.slideshow').data('effect') : 'slide';

			$('.slideshow').slides({
				generateNextPrev: true,
				generatePagination: true,
				hoverPause: true,
				play: slideshowPlay,
				effect: slideshowEffect
			});
			
			// Center Slideshow Pagination
			$('.slideshow').each(function() {
				var pager = $(this).find('.pagination');
				pager.css('left', (470 - ((pager.outerWidth()/2)+10)) + 'px');
			});
			
			$('html:not(.ie8):not(.ie7) .slideshow').hoverIntent({
				over: function() { $(this).find('.prev, .next').fadeTo(220, 0.4); },
				out: function() { $(this).find('.prev, .next').fadeTo(220, 0); }
			});
			
			$('html:not(.ie8):not(.ie7)').find('.slideshow .prev, .slideshow .next').hoverIntent({
				interval: 20,
				over: function() { $(this).fadeTo(10, 1); },
				out: function() { $(this).fadeTo(220, 0.4); }			
			});

			// IE8 & IE7 Banner Interaction
		    $('html.ie8, html.ie7').find('.slideshow').hoverIntent({
            	over: function() { $(this).find('.prev, .next').show(); },
            	out: function() { $(this).find('.prev, .next').hide(); }
            });
		}
		
		// Feature Overlay
		if($('#overlay-features').length) {
			$('.feature .feature-overlay').click(function(e) {
				window.location.href = $(this).parent().find('a').attr('href');
				e.preventDefault();
			});
			$('.feature').hoverIntent({
				interval: 20,
				over: function() { 
					$(this).find('.feature-overlay').show();
				}, 
				out: function() {
					$(this).find('.feature-overlay').hide();
				}			
			});
		}
		
		// Notifications Slide In & Close Behavior
		displayMessages();
		
		// Compare Slide In & Behavior
		if($('#compare-products-pane').length) {
			var shownToUser = false;
			
			if($('.success-msg:contains("comparison list")').length) {
				// Show user the compare pane if recently added compare item
				$('#compare-products-pane').addClass('compare-active');
				$('body').addClass('push-it');			
			}
			
			var waitToInit = setTimeout(function() {
				$('#compare-button').mouseenter(function(e) {
					$('#compare-products-pane').addClass('compare-active');
					$('body').addClass('push-it');
				
					if($('.success-msg:contains("comparison list")').length)
						$('#compare-button').removeClass('compare-fade-color');
				});
			}, 1000);

			$('#compare-products-pane').mouseleave(function(e) {
				$(this).removeClass('compare-active');
				$('body').removeClass('push-it');
				
				if($('.success-msg:contains("comparison list")').length && shownToUser === false) {
					$('#compare-button').addClass('compare-fade-color');
					shownToUser = true;
				}
			});
		}
		
		// Language/Currency Switcher
		if($('#cart-menu .flags').length) {
			$('#cart-menu .flags').hoverIntent({
				interval: 20,
				over: function() { 
					$('.currency-selector').appendTo('#cart-menu .flags');
					$('.currency-selector').show();
				}, 
				out: function() {
					if(!$('.currency-selector').hasClass('hasFocus'))
						$('.currency-selector').hide();
				}
			});
			
			$('.currency-selector').live('focus', function() {
				$(this).addClass('hasFocus');
			}).live('blur', function() {
				$(this).removeClass('hasFocus').hide();
			});
		}
	});

	function initQuickCart() {
		if($('.quickcart').length && !$('.no-items-in-cart').length) {
			$('.cart').unbind().hoverIntent({
				interval: 20,
				over: function() { $(this).addClass('cart-active').find('.quickcart').show(); }, 
				out: function() { $(this).removeClass('cart-active').find('.quickcart').hide(); }			
			});
		}
	}

	function displayMessages() {
		if($('.messages').length) {
			if(!$('.messages').parent().is('.global-messages, .page-messages').length) {
				$('.messages').wrap('<div class="page-messages" />');

				// Append close button to messages
				if(!$('.messages').parent().find('.messages-close').length)
					$('.messages').parent().append('<div class="messages-close"><a href="#" class="ir">Close</a></div>');

				$('.messages-close').appendTo('.page-messages');
			}
			$('.messages').parent().addClass('messages-active');
			
			// IE6-7 Z-Index & Zoom Fix
			if($('.ie7 .messages, .ie6 .messages').length) {
				$('.ie7 .messages, .ie6 .messages').closest('div[class*="grid_"]').css({
					position: 'relative',
					'zIndex': 9999
				});
			}
			
			var open = setTimeout(function() {
				$('.messages-close a').css('display', 'block').click(function(e) {
					$('.messages').parent().removeClass('messages-active');
					$('.messages-close').remove();
					e.preventDefault();
				});
			}, 400);
		}
	}

    $.fn.center = function() {
	    this.css("position", "absolute");
	    this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
	    this.css("left", (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + "px");
	    return this;
	}
})(jQuery);