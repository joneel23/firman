/**
 * Created by BlueFoxDev on 5/2/2018.
 */

jQuery(document).ready(function ($) {

    //$('.zoom').magnify();

    var global_init = {

        run: function () {
            this.tabClickTransition();
        },

        equalizeHeightContainer: function (ele, add_height ) {
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
        }

    };

    global_init.run();

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
