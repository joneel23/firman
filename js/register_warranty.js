jQuery(document).ready(function ($) {
    var $warrant_form = $('#wpcf7-f1053-p1054-o1, #wpcf7-f102-p24-o1');
    $warrant_form.on('mailsent.wpcf7', function () {
        var first_name = $warrant_form.find('.FirstName input').val();
        var last_name = $warrant_form.find('.LastName input').val();
        var email = $warrant_form.find('.your-email input').val();
        var model = $warrant_form.find('.Model select').val();
        var page_id = $warrant_form.find('.Model select option:selected').data('pid');
        first_name = Base64.encode(first_name);
        last_name = Base64.encode(last_name);
        email = Base64.encode(email);
        var warranty_query = 'fname=' + first_name + '&lname=' + last_name + '&email=' + email + '&product_name=' + model + '&product_id=' + page_id;

        if( page_id == '' || page_id == null || page_id == undefined ){
            location.replace( location.href + "register-warranty-successful/" );

        } else {
            location.replace( location.href + "register-warranty-successful/?" + warranty_query);
        }

        console.log('Register Warranty Submitted');
    });
    console.log(location.href);
});