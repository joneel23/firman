/**
 * Created by BlueFoxDev on 5/2/2018.
 */

jQuery(document).ready(function ($) {

    //$('.zoom').magnify();

    //mobile
    $("#mobile-filter button").click(function(){

       if( $(this).hasClass('off-filter') ) {
           var text = $(this).attr('data-textShow');
           $(this).text("Hide filter");
           $(this).removeClass('off-filter');
           $('aside:first').removeClass('off-filter');
       } else {
           var text = $(this).attr('data-textHide');
           $(this).text("Display filter");
           $(this).addClass('off-filter');
           $('aside:first').addClass('off-filter');
       }
    });
    // $("#mobile-filter button").toggle(
    //     function(){
    //         var text = $(this).data('textShow');
    //         $(this).text(text);
    //     },
    //     function(){
    //         var text = $(this).data('textHide');
    //         $(this).text(text);
    //     }
    // );

    var global_init = {

        run: function () {
            this.tabClickTransition();
        },

        equalizeHeightContainer: function (ele, add_height ) {
            //reset height
            $(ele).map(function (i, e) {
                    return $(e).css('height', 'auto');
            });

            var maxHeight = $(ele).map(function (i, e) {
                return $(e).height() + add_height;
            }).get();
            console.log(maxHeight);

            return $(ele).height(Math.max.apply($(ele), maxHeight ));
        },

        tabClickTransition: function() {
            $('.tabs.wc-tabs > li > a').on('click', function(event){
                event.stopPropagation();
                $('.tabs.wc-tabs > li > a').parent().removeClass('active');

                var parent_id = $(this).parent().attr('id');
                $('#'+parent_id).addClass('active');
                // Make sure this.hash has a value before overriding default behavior
                $('.woocommerce-Tabs-panel').hide();
                var data_href = $(this).data('href');

                $('#'+data_href).css('opacity', 0.5);

                console.log(data_href);
                if (data_href !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    $('#'+data_href).show();
                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('#'+data_href).animate({
                        opacity: 1,
                    }, 500, function(){
                    });

                } // End if

            });
        },

        checkWindowWidth: function(width){
            if( width <= 360 ){
                $('#tab-title-description').find('a').text('Desc');
                $('#tab-title-specification').find('a').text('Specs');
                $('#tab-title-additional_information').find('a').text('Additional Info');
            }
        }

    };

    global_init.run();
    var archive_meta_height, single_meta_height;
    var innerWidth = window.innerWidth;
    global_init.checkWindowWidth(innerWidth);

    $(window).resize(function(){
        var $body = $('body');
        var width = $(window).width();
        console.log(innerWidth);
        global_init.checkWindowWidth(width);

        if($body.hasClass('archive') ){
            global_init.equalizeHeightContainer('.product-item-container', 30);
        }
        if($body.hasClass('single-product') ){
            global_init.equalizeHeightContainer('.product-item-container', 30);

        }
        $('.product-item-container').find('.btn-container').addClass('pos-absolute');
    });

    setTimeout(function () {
        var $body = $('body');

        if($body.hasClass('archive') ){
            global_init.equalizeHeightContainer('.product-item-container', 0);
        }
        if($body.hasClass('single-product') ){
            global_init.equalizeHeightContainer('.product-item-container', 10);

        }
        $('.product-item-container').find('.btn-container').addClass('pos-absolute');
    }, 2000)
});
