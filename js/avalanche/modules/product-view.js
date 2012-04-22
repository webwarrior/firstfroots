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
		var productPhotoWidth = $('#product-image img').width();
		
		// Product Image Strip
		if($('.product-image-thumbnail').length) {
			$('.product-image-thumbnail').live('click', function(e) {
				var imgContainer = $('#product-image');
				var imgUrl = $(this).metadata({ name: 'data-img', type: 'attr' }).img;
				var img = new Image();
				$(img).attr({ 'width': productPhotoWidth });
				
				$(img).load(function() {
					var link = ($('#product-image a').hasClass('cloud-zoom')) ? '<a href="'+imgUrl+'" class="cloud-zoom"/>' : '';
					imgContainer.hide().html($(this));
					imgContainer.find('img').wrap(link).attr('width', productPhotoWidth);
					imgContainer.fadeIn('fast').find('.cloud-zoom, .cloud-zoom-gallery').CloudZoom();
				}).attr('src', imgUrl);
					
				e.preventDefault();
			});
		}
		
		// HTML5 Validation Fix for IFrame. Clone so attributes stick around in IE.
		if($('.ie7, .ie8').length) {
			$('#facebook-like iframe').clone().attr({ 'frameBorder': '0', 'allowTransparency': 'true', 'scrolling': 'no' }).appendTo('#facebook-like');
			$('#facebook-like iframe').first().remove();
		}
		
		// IE6-7 Image Strip Center
		if($('.ie7 #product-image-strip, .ie6 #product-image-strip').length) {
			var imgStrip = $('.ie7 #product-image-strip ul, .ie6 #product-image-strip ul');
			var stripWidth = imgStrip.find('li:first-child').outerWidth() * imgStrip.find('li').length;
			imgStrip.width(stripWidth);
		}

		// Quantity Spinner
		if($('#quantity-spinner').length) {
			$('#quantity-spinner #q-more, #quantity-spinner #q-less').click(function(e) { 
				e.preventDefault();
			});
			$('#quantity-spinner #q-more').mousehold(200, function(i) {
				$('#quantity').val(parseInt($('#quantity').val(),0) + 1);
			});
			$('#quantity-spinner #q-less').mousehold(200, function(i) {
				if(parseInt($('#quantity').val(),0) > 1)
					$('#quantity').val(parseInt($('#quantity').val(),0) - 1);
			});
		}
		
		// Write Review Lightbox
		if($('#write-review-link').length) {
			$('#write-review-link').click(function(e) {
				$('#write-review').lightbox_me({
					centered: true, 
					onLoad: function() {
						// Load Image
						$('#write-review #review-image img').attr('src', $('#product-image img').attr('src')).parent().show();
					
						// Rating Selector
						$('.rating-star').rating({
							required: true, starWidth: 15
						});

						if($('#upload-photo-link').length) {
							$('#upload-photo-link').click(function(e) {
				                $('#upload-photo-container').toggle();
				                $('#write-review').trigger('reposition');
				                e.preventDefault(); 
				           });
				        }
					}
				});
			
				e.preventDefault();
			});
		}
	});
})(jQuery);

jQuery.fn.mousehold = function(timeout, f) {
	if (timeout && typeof timeout == 'function') {
		f = timeout;
		timeout = 100;
	}
	if (f && typeof f == 'function') {
		var timer = 0;
		var fireStep = 0;
		return this.each(function() {
			jQuery(this).mousedown(function() {
				fireStep = 1;
				var ctr = 0;
				var t = this;
				timer = setInterval(function() {
					ctr++;
					f.call(t, ctr);
					fireStep = 2;
				}, timeout);
			})

			clearMousehold = function() {
				clearInterval(timer);
				if (fireStep == 1) f.call(this, 1);
				fireStep = 0;
			}
			
			jQuery(this).mouseout(clearMousehold);
			jQuery(this).mouseup(clearMousehold);
		})
	}
}