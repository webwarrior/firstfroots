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
	// Update media legend
	$('#media-legend span:first-child').addClass('active');

	// Set initial photo container width
	$('#product-images').css('width', ($('#product-image-browser').width() * $('#product-images li').length) + 'px');
	$('#product-images li').css('width', $('#product-image-browser').width() + 'px');

	// Update width on orientation change
	$(window).bind('orientationchange', function(event) {
		$('#product-images').css('width', ($('#product-image-browser').width() * $('#product-images li').length) + 'px').css('marginLeft', 0);
  		$('#product-images li').css('width', $('#product-image-browser').width() + 'px');
  		$('#media-legend span').removeClass('active');
		$('#media-legend span').eq(0).addClass('active');
  		current = 0;
	});

	// Fix swiping on Android
	if($.os.android) {
		var disableDefault = function(e) {
			e.preventDefault();
		};
		$('#product-images').bind('touchstart', function() {
			document.addEventListener('touchmove', disableDefault);
		}).bind('touchend', function() {
			document.removeEventListener('touchmove', disableDefault);
		});
	}

	var count = $('#product-images li').length - 1;
	var current = 0;

	$('#product-images').swipeLeft(function() {
		// Make sure we have an additional image
		if(current !== count) {
			current++;

			// Move to the left by size of window
			$(this).css('marginLeft', '-' + ($('#product-image-browser').width() * current) + 'px');

			// Update legend
			$('#media-legend span').removeClass('active');
			$('#media-legend span').eq(current).addClass('active');
		} else {
			current = -1;
			$(this).trigger('swipeLeft');
		}
	}).swipeRight(function() {
		if(current !== 0) {
			current--;

			$(this).css('marginLeft', '-' + ($('#product-image-browser').width() * current) + 'px');

			$('#media-legend span').removeClass('active');
			$('#media-legend span').eq(current).addClass('active');			
		} else {
			current = count + 1;
			$(this).trigger('swipeRight');
		}
	});

	// Override options text
	$('.super-attribute-select').each(function() {
        $(this).find('option').first().html($(this).data('text')); 
    });

    // Clone
    $.fn.clone = function() {
		var ret = $();
		this.each(function() {
			ret.push(this.cloneNode(true))
		});
		return ret;
	};

	// Floatable Header
	function floatyHeader() {
		var floatObject = $('#product-header').data('float');

		if(floatObject.length) {
			var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
	    	if(scrollTop > 420) {
	    		if(!$(floatObject).hasClass('show-product-header')) {
	    			$(floatObject).removeClass('hide-product-header').addClass('show-product-header');
	    		}
	    	} else {
	    		if($(floatObject).hasClass('show-product-header')) {
	    			$(floatObject).removeClass('show-product-header').addClass('hide-product-header');
	    		}
	    	}
	    }
	}

	if($('#product-options-wrapper').height() > 200) {
	    $(window).bind('scroll', function() {
	    	// If extended configurable product, show floatable header
	    	floatyHeader();
	    });
	}

	// Share Button
	$('#share-button').click(function(e) {
		if($('#share-container').length) {
			var shareMenu = $('#share-container').html();
			$('#share-container').remove();
			$('body').append(shareMenu);
		}

		$('.lb-overlay .close-button').unbind().click(function(e) {
			$('.lb-overlay').removeClass('active').css({ 'width': 0, 'height': 0 });
			e.preventDefault();
		});

		var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
		var centerTop = ((($(window).height() - $('.lb-menu').height()) / 2) - 120 + scrollTop) + 'px';
		$('.lb-menu').css('marginTop', centerTop);
		$('.lb-overlay').addClass('active').width($('body').width()).height($('body').height()).unbind().click(function(e) {
			if($(e.target).hasClass('lb-overlay')) {
				$('.lb-overlay').removeClass('active').css({ 'width': 0, 'height': 0 });
			}
			e.stopPropagation();
		});

		e.preventDefault();
	});
})(Zepto);