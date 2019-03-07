// Price range slider code
jQuery( function($) {
    $( "#slider-range" ).slider({
        range: true,
        min: 1,
        max: 3000,
        values: [ 1, 3000 ],
        slide: function( event, ui ) {
            jQuery( "#book_price" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            jQuery("#start_price").val(ui.values[ 0 ]);
            jQuery("#end_price").val(ui.values[ 1 ]);
        }
    });
    jQuery( "#book_price" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) +
        " - $" + $( "#slider-range" ).slider( "values", 1 ) );
} );

jQuery(document).ready( function($) {
    search_book_ajax_fun(0);
    // AJAX call for bookj search
    jQuery("#book_search_btn").click( function() {
        search_book_ajax_fun(0);
    });
    
    jQuery(".reset_data").click( function() {
        jQuery("#book_name").val('');
        jQuery("#book_author").val('');
        jQuery("#book_publisher").val('');
        jQuery("#book_rating").val('');
        
        search_book_ajax_fun(0);
    });
});

function search_book_ajax_fun(page){
    jQuery("#book_search_btn").prop("disabled", true);
    jQuery(".ajax_loader_image").show();
    var request_data = jQuery('#search_book').serialize();
    var data = {
        type: 'POST',
        action: 'search_books',
        request_data: request_data,
        page: page
    };
    // the_ajax_script.ajaxurl is a variable that will contain the url to the ajax processing file
    jQuery.post(the_ajax_script.ajaxurl, data, function(response) {
        jQuery("#book_search_btn").prop("disabled", false);
        jQuery(".ajax_loader_image").hide();
        jQuery('#table tbody').html(response);
    });
    return false;
}

jQuery(document).ready(function($) {
    jQuery(document).on("click",".book_pagination ul li a",function() {
        var page = jQuery(this).attr("data-page");
        search_book_ajax_fun(page);
    });
});

jQuery(document).on("keypress", "#book_name", function(e) {
     if (e.which == 13) {
        search_book_ajax_fun(0);
     }
});