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
	new MBP.fastButton($('button'), function() { $(this).trigger('click'); });
	MBP.scaleFix();
	MBP.hideUrlBar();

	// Body Classes
	if($.os.ios)
		$('body').addClass('ios');
	if($.os.android)
		$('body').addClass('android');
	if($.os.blackberry)
		$('body').addClass('blackberry');
	if($.os.webos)
		$('body').addClass('webos');

	$('#category-menu').browser();

	$('#category-menu').on('click', function(e) {
		$('#category-list').toggleClass('hide-side-area');
		$('#container').toggleClass('side-revealed');
		if(!$('#category-list').hasClass('hide-side-area')) {
			resizeCols();
		} else {
			resetCols();
		}
		e.preventDefault();
	});

	// Notifications
	if($('.global-messages .messages').length) {
		$('.global-messages').addClass('messages-active');
	}
	if($('.page-messages .messages').length) {
		$('.page-messages').addClass('messages-active');
	}
	$('.global-messages .messages, .page-messages .messages').click(function(e) {
		$('.global-messages, .page-messages').removeClass('messages-active');
		e.stopPropagation();
	});

	// Homepage Sliders
	sliders();

	// Homepage Button
	if($('.homepage-button a').length) {
		$('.homepage-button a').click(function(e) {
			$('#category-menu').trigger('click');
			setTimeout(function() { window.scrollTo(0, 1); }, 50);
			e.preventDefault();
		});
	}

	// Homepage Carousels
	if($('.carousel-photos').length) {
		$('.carousel-photos').each(function() {
			var carousel = $(this);
			var current = -1;
			var carouselWidth = $(this).width();
			var itemCount = carousel.find('li').length;
			var itemWidth = carousel.find('li').first().width();
			var titleBar = carousel.closest('.white-box').find('.carousel-photos-title');
			carousel.find('.fill').css('width', itemWidth);
			carousel.closest('.carousel').css('width', (((itemWidth*1.25) * itemCount) + Math.floor(itemWidth / 2)) + 'px');
			carousel.closest('.carousel-container').bind('scroll', function() {
				if(($(this)[0].scrollLeft / itemWidth) === 0) {
					var firstItem = 0;
				} else {
					var firstItem = Math.floor(($(this)[0].scrollLeft / itemWidth) + 0.5);
				}
	    		if(firstItem !== current) {
		    		if(!carousel.find('li').eq(firstItem).hasClass('fill')) {
		    			carousel.find('li').removeClass('selected');
		    			carousel.find('li').eq(firstItem).addClass('selected');
		    			var name = carousel.find('li').eq(firstItem).data('name');
		    			var price = carousel.find('li').eq(firstItem).data('price');
		    			titleBar.html(name + '<div class="stars"><span class="active">&#9733;</span><span class="active">&#9733;</span><span class="active">&#9733;</span><span class="active">&#9733;</span><span class="active">&#9733;</span></div><span class="price">' + price + '</span>');
		    		}
		    		current = firstItem;
	    		}
	    	});
		});
	}

	// Side Cart Panel -- Finish Later
	/*$('#menu-cart').on('click', function(e) {
		if(!$(this).find('.count').length) { // Go directly to cart if no items
			return;
		}

		if(!$('#container').hasClass('side-revealed-right')) { // Load Cart
			$('#cart-preview').removeClass('hide-side-area');
			$('#container').addClass('side-revealed-right');
			ajaxLoader();

			$.getJSON($('body').data('baseurl') + 'mobile/cart/ajax/', function(data) {
				$('#ajax-loader-container').remove();

				if(data.quickcart) {
					$('#cart-preview').removeClass('hide-side-area');
					$('#container').addClass('side-revealed-right');
					$('#cart-preview .side-content').html(data.quickcart);
				}
			});
		} else { // Hide Cart
			$('#cart-preview').addClass('hide-side-area');
			$('#container').removeClass('side-revealed-right');
		}

		e.preventDefault();
	});*/

	$('#search-submit').on('click', function(e) {
		$('#search-form').submit();
	});

	function resizeCols() {
		var categoryList = $('#category-list');
		var viewport = $('#viewport');

		categoryList.height(categoryList.find('.side-content').height());

		if(categoryList.height() > viewport.height()) {
			viewport.height(categoryList.height());
		}
	}

	function resetCols() {
		var categoryList = $('#category-list');
		var viewport = $('#viewport');
		
		viewport.height('100%');		
	}

	function ajaxLoader() {
		$('body').append('<div id="ajax-loader-container"><div id="ajax-loader"></div></div>');
		var opts = { lines: 12, length: 6, width: 2, radius: 12, color: '#fff', speed: 1.4, trail: 60, hwaccel: true };
		var target = document.getElementById('ajax-loader');
		var spinner = new Spinner(opts).spin(target);
	}

	function sliders() {
		if($('.slider-container').length) {
			// Set initial photo container width
			$('.slider').css('width', ($('.slider-container').width() * $('.slider li').length) + 'px');
			$('.slider li').css('width', $('.slider-container').width() + 'px');

			// Update width on orientation change
			$(window).bind('orientationchange', function(event) {
				$('.slider').css('width', ($('.slider-container').width() * $('.slider li').length) + 'px').css('marginLeft', 0);
		  		$('.slider li').css('width', $('.slider-container').width() + 'px');
		  		current = 0;
			});

			// Fix swiping on Android
			if($.os.android) {
				var disableDefault = function(e) {
					e.preventDefault();
				};
				$('.slider').bind('touchstart', function() {
					document.addEventListener('touchmove', disableDefault);
				}).bind('touchend', function() {
					document.removeEventListener('touchmove', disableDefault);
				});
			}

			var count = $('.slider li').length - 1;
			var current = 0;
			var slideshowInterval = $('.slider-container').data('interval') || 5;
			var timer = setInterval(function() { $('.slider').trigger('swipeLeft'); }, slideshowInterval * 1000);

			$('.slider').swipeLeft(function() {
				// Make sure we have an additional image
				if(current !== count) {
					current++;

					// Move to the left by size of window
					$(this).css('marginLeft', '-' + ($('.slider-container').width() * current) + 'px');
					if(timer) {
						clearInterval(timer);
						timer = 0;
					}
				} else {
					current = -1;
					$(this).trigger('swipeLeft');
				}
			}).swipeRight(function() {
				if(current !== 0) {
					current--;

					$(this).css('marginLeft', '-' + ($('.slider-container').width() * current) + 'px');
					if(timer) {
						clearInterval(timer);
						timer = 0;
					}
				} else {
					current = count + 1;
					$(this).trigger('swipeRight');
				}
			});
		}
	}
})(Zepto);