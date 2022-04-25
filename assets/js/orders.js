jQuery('#search_by').change(function () {
    if (jQuery(this).val() == "") {
        jQuery('#search_query').attr('disabled', true);
    } else {
        jQuery('#search_query').attr('disabled', false);
    }
});

//searching script
jQuery('#search_query').on('keyup', function () {

    var templateUrl = get_url;
    // templateUrl+="get_data.php";
    //console.log($(this).val());
    jQuery.ajax({
        type: 'GET',
        data: {
            page_type: 'orders',
            search_query: jQuery("#search_query").val(),
            search_by: jQuery("#search_by").val()
        },
        url: templateUrl,
        success: function (value) {
            //console.log(value);
            jQuery('#content').html('');
            jQuery('#content').html(value);
        }
    })
})


function get_page(id) {
    var templateUrl = get_url;
    //   templateUrl+="get_data.php";
    var search_query = jQuery("#search_query").val();
    var search_by = jQuery("#search_by").val();

    if (search_query === "") {
        search_query = null;
    }
    if (search_by === "") {
        search_by = null;
    }
    jQuery.ajax({
        type: 'GET',
        data: {
            page_type: 'orders',
            page_no: id,
            search_query: search_query,
            search_by: search_by
        },
        url: templateUrl,
        success: function (value) {
            //console.log(value);
            jQuery('#content').html('');
            jQuery('#content').html(value);
        }
    })
}