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
		$('.input-text-colorpicker').miniColors();

		$('.select-background-preview').each(function() {
			var select = $(this);
			select.change(function() {
				var optVal = $(this).find('option:selected').val();
				var previewBox = select.parent().find('.previewer');
				optVal = optVal.replace("url('../", "url('"+previewBox.data('root')+"frontend/avalanche/default/");
				//$(this).closest('fieldset').css('background', optVal);
				previewBox.html('&nbsp;').css('background', optVal);
			});
		});

		$('.select-font-preview').each(function() {
			var select = $(this);
			select.change(function() {
				var optVal = $(this).find('option:selected').val();
				var previewBox = select.parent().find('.previewer');
				loadFont(optVal);

				if(select.attr('id') === 'avalanche_config_avalanche_design_avalanche_bodyfont') {
					var loremIpsum = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum sed augue a diam convallis condimentum. Cras lacinia elit ut nisi volutpat ut ultricies purus varius. Sed sed risus et est porta placerat. Morbi mollis, orci eget volutpat fermentum."
					+ "</p><p>Nulla facilisi. Quisque in lorem ante, vel tempor odio. Maecenas faucibus massa ac sapien elementum pretium. Nulla imperdiet scelerisque mi, ut facilisis enim cursus ut. Ut adipiscing eleifend felis, at ultricies leo vehicula."
					+ " Morbi nec placerat nibh.</p>";
					previewBox.hide().html(loremIpsum).css({'font-family': optVal, 'text-align': 'left', 'color': '#333', 'font-size': '13px', 'line-height': '1.4em'}).fadeIn('fast');
				} else {
					previewBox.hide().html('Avalanche: Take Magento Further').css({'font-family': optVal, 'text-align': 'center', 'color': '#333', 'font-size': '16px', 'line-height': '1.4em'}).fadeIn('fast');
				}
			});
		});
	});

	function loadFont(family) {
		WebFontConfig = {
			google: { families: [ family ] }
		};

		(function() {
			var wf = document.createElement('script');
			wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
			    '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
			wf.type = 'text/javascript';
			wf.async = 'true';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(wf, s);
		})();
	}
})(jQuery);