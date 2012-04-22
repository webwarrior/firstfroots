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
    var currentPage = 1;
    
    $.fn.catalogAjax = function(l) {
        var plugin = {
          init: function(d) {
              if($('#last-page').data('config')) {
                  return;
              }
              
              config = {
                  gridColumn: '#results',
                  catalogPageSelector: '.catalog-page',
                  productlinkselector: '.item a',
                  contentheightselector: 'body',
                  onPageLoaded: null,
                  googleAnalytics: true,
                  showMoreTemplate: '<a class="show-more-link" href="#" data-nextpage="2">Show More Products</a>'
              };
              
              // On hash updates...
              $(window).bind('hashchange', function(e) {
                  $(config.gridColumn).catalogAjax('getPage', true);
              });
              
              // Get page on init...
              $(config.gridColumn).catalogAjax('getPage', false);
              
              if(d) {
                  $.extend(config, d);
              }
              
              // Assign configuration data to #last-page div
              $("#last-page").data('config', config);
              
              // Special JS to call when a new page is loaded
              if(config.onPageLoaded) {
                  $('body').bind('productsloaded', config.onPageLoaded);
              }
              
              // Google Analytics
              if(config.googleAnalytics) {
                  $('body').bind('productsloaded', function(a, b, c) {
                      //_gaq.push(['_trackPageview', c.url]);
                      //_gaq.push(['_trackEvent', 'infinitescroll', 'loadpage', c.url]);
                      //_gaq.push(['_trackEvent', 'infinitescroll', 'numberLoaded', 'page-' + (c.number < 10 ? '0' : '') + c.number])
                  });
              }
              
              // Hide the pager
              $('.pager').each(function() {
                if(!$(this).hasClass('pager-visible')) {
                  $('.pager').hide();
                }
              });

              var catalogPageSet = null;
              catalogPageSet = $(document.createElement($(config.catalogPageSelector).get(0).nodeName))

              var showMoreLink = $(config.showMoreTemplate);
              showMoreLink.click(function(e) {
                  $(config.gridColumn).catalogAjax('nextPage', false);
                  e.preventDefault();
              });
              
              catalogPageSet.append(showMoreLink);
              $(config.catalogPageSelector).parent().append(catalogPageSet);
              
              if($.deparam.querystring()['p']) {
                  currentPage = $.deparam.querystring()['p'];
              }
              
              // If last page, then hide show more link
              if(currentPage == $('#last-page').data('number')) {
                  showMoreLink.hide();
              }
          },
          
          nextPage: function(rebound, reboundCurrentPage) {
              if(!rebound) {
                  currentPage++;
              }

              $.bbq.pushState({ page: currentPage });

              if(!rebound) {
                var nextUrl = $.param.querystring(document.location.href, 'p=' + currentPage);
              } else {
                var nextUrl = $.param.querystring(document.location.href, 'p=' + reboundCurrentPage);
              }
              
              $('.show-more-link').addClass('show-more-loading').html('<img src="' + $('#show-more-loader').data('src') + '"/>');
               
              $.ajax({
                   url: nextUrl,
                   success: function(data) {
                       var content = $(data).find('.catalog-page');
                       $('.catalog-page').last().after(content);
                       
                       // If last page, then hide show more link
                       if(currentPage == $('#last-page').data('number')) {
                           $('.show-more-link').hide();
                       } else {
                           $('.show-more-link').removeClass('show-more-loading').html('Show More Products');
                       }

                       // Trigger page loaded on success function
                       $('body').trigger('productsloaded');

                       $('html, body').animate({ 'scrollTop': $('.catalog-page:eq('+(currentPage-1)+')').offset().top }, 500, function() {
                           $('.catalog-page').waypoint(function(event, direction) {
                               $.bbq.pushState({ page: parseInt($(this).index()) });
                           });
                       });
                   },
                   headers: {
                       "X_REQUESTED_WITH": "browser",
                       "X-Requested-With": "browser"
                   },
                   beforeSend: function (a, b) {
                       a.setRequestHeader("X_REQUESTED_WITH", "browser");
                       a.setRequestHeader("X-Requested-With", "browser")
                   }
               });
          },
          
          getPage: function(hashchange) {
              // If page hash available, set current page
              var catalogQuery = $.deparam.querystring();
              var catalogFragment = $.deparam.fragment();
              
              if(catalogQuery['p'] && !hashchange) {
                  currentPage = catalogQuery['p'];
                  $.bbq.pushState({ page: catalogQuery['p'] });
                  hashchange = true;
              } else {
                  if(catalogFragment['page']) {
                      currentPage = catalogFragment['page'];
                  } else {
                      // If no page hash, set to 1
                      $.bbq.pushState({ page: currentPage });
                  }
              }

              // Scroll to current page if not 1
              if(currentPage !== 1 && !hashchange) {
                  // If catalog pages haven't been opened yet
                  for(var x = 2; x <= currentPage; x++) {
                      if(x <= $('#last-page').data('number')) {
                          $('.catalog-page').waypoint('destroy');
                          $('#results').catalogAjax('nextPage', true, x);
                      }
                  }
              }
          }
        };
        
        if(plugin[l]) {
            return plugin[l].apply(this, Array.prototype.slice.call(arguments, 1))
        } else if(typeof l === 'object' || !l) {
            return plugin.init.apply(this, arguments)
        } else {
            $.error('Method ' + l + ' does not exist on jQuery.catalogAjax')
        }
    }
})(jQuery);