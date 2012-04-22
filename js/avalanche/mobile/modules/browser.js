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
;(function ( $, window, document, undefined ) {

    var pluginName = 'browser',
        defaults = {
            currentStep: 1
        };

    function Browser( element, options ) {
        this.element = element;
        this.options = $.extend( {}, defaults, options) ;
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    };

    Browser.prototype.init = function () {
        // Place initialization logic here
        // You already have access to the DOM element and the options via the instance, 
        // e.g., this.element and this.options
        var that = this;

        $('#category-list .level0 a').each(function() {
            var area = $(this).closest('li').find('.area');
            if(area.length) {
                $(this).attr('href', 'javascript:void(0)');
            }
        });

		$('#category-list ul li a').live('click', function(e) {
            var area = $(this).closest('li').find('.area');
            if(area.length) {
                that.next(area);
                e.preventDefault();
            }
		});

        $('#side-nav-back').on('click', function(e) {
            that.prev();
            e.preventDefault();
        });

        $('#side-area-close').on('click', function(e) {
            $('#category-menu').trigger('click');
            that.reset();
            e.preventDefault();
        });

        this.navObserver();
    };

    Browser.prototype.next = function(area) {
        var areaName = area.closest('li').find('a span').html();
        $('#category-list .side-nav-title').html('<a href="#" class="home">' + areaName + '</a>');
        this.options.currentStep++;

        if($('.category-overlay-active').length) {
            $('#category-overlay' + (this.options.currentStep - 1)).addClass('category-overlay-inactive');

            if(!$('#category-overlay' + this.options.currentStep).length) {
                $('<div id="category-overlay' + this.options.currentStep + '" class="category-overlay"></div>').appendTo('#category-list');
            }
            var overlay = document.getElementById('category-overlay' + this.options.currentStep);
            window.getComputedStyle(overlay).getPropertyValue('top');
            $('#category-overlay' + this.options.currentStep).html(area.html()).addClass('category-overlay-active').attr('data-title', areaName);
        } else {
            $('#category-overlay2').html(area.html()).addClass('category-overlay-active').attr('data-title', areaName);
            $('#category-list .side-content > ul').attr('class', 'category-list-hide');
        }

        this.navObserver();   
    };

    Browser.prototype.prev = function() {
        if((this.options.currentStep - 1) !== 1) {
            $('#category-list .side-nav-title').html('<a href="#" class="home">' + $('#category-overlay' + (this.options.currentStep - 1)).data('title') + '</a>');
            $('#category-overlay' + this.options.currentStep).removeClass('category-overlay-active');
            $('#category-overlay' + (this.options.currentStep - 1)).removeClass('category-overlay-inactive');
        } else {
            $('#category-list .side-nav-title').html('<a href="#" class="home">Browse Store</a>');
            $('#category-overlay' + this.options.currentStep).removeClass('category-overlay-active');
            $('#category-list .side-content > ul').attr('class', 'category-list-show');
        }

        this.options.currentStep--;
        this.navObserver();
    };

    Browser.prototype.reset = function() {
        for(var x = this.options.currentStep; x >= 3; x--) {
            $('#category-overlay' + x).remove();
        }

        $('#category-overlay2').html('').attr('class', '');
        $('#category-list .side-content > ul').removeClass('category-list-hide');

        this.options.currentStep = 1;
        this.navObserver();
    };

    Browser.prototype.navObserver = function() {
        if(this.options.currentStep !== 1) {
            $('#side-nav-back').show();
        } else {
            $('#side-nav-back').hide();
        }
    };

    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$(this).data('plugin_' + pluginName)) {
                $(this).data('plugin_' + pluginName, new Browser( this, options ));
            }
        });
    };

})( Zepto, window, document );