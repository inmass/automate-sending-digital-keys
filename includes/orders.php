<?php
include('functions.php');

global $wpdb;
$tablename = $wpdb->prefix."asdk_keys_users";
$query = $wpdb->get_results("SELECT * FROM $tablename");
?>

<p class="search-box">
    <br>
    <label for="search_by">Search by</label>
    <select name="search_by" id="search_by">
        <option value="" selected disabled></option>
        <option value="sent_to">Buyer</option>
        <option value="key_type">Key type</option>
        <option value="activation_key">Key</option>
    </select>
    <input type="search" id="search_query" name="search_query" placeholder="Query here" value="" disabled>
    <br><br>
</p>

<div>
    <h1>Orders</h1>
    <table width='100%' border='1' class="wp-list-table widefat fixed striped pages " style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th>Id</th>
                <th>Date</th>
                <th>Buyer</th>
                <th>Key</th>
                <th>Product</th>
            </tr>
        </thead>

        <tbody id="content" >
            <?php orders_per_page(1,20,null); ?>
        </tbody>
    </table>
</div>

<a href="<?php echo admin_url('admin.php?page=add-key-type'); ?>">Add new key type</a>



<!-- creating js functions -->
<script>
    jQuery('#search_by').change(function(){
        if (jQuery(this).val() == "") {
            jQuery('#search_query').attr('disabled', true);
        } else {
            jQuery('#search_query').attr('disabled', false);
        }
    });

    //searching script
    jQuery('#search_query').on('keyup',function(){

        var templateUrl = '<?= plugin_dir_url( __FILE__ ); ?>get_data.php';
        // templateUrl+="get_data.php";
        //console.log($(this).val());
        jQuery.ajax({
            type:'GET',
            data:{
                page_type: 'orders',
                search_query:jQuery("#search_query").val(),
                search_by:jQuery("#search_by").val()
            },
            url:templateUrl,
            success: function(value) {
                //console.log(value);
                jQuery('#content').html('');
                jQuery('#content').html(value);
            }
        })
    })


    function get_page(id)
    {
        var templateUrl = '<?= plugin_dir_url( __FILE__ ); ?>get_data.php';
        //   templateUrl+="get_data.php";
        var search_query=jQuery("#search_query").val();
        var search_by=jQuery("#search_by").val();
        
        if(search_query==="")
        {
            search_query=null;
        }
        if(search_by==="")
        {
            search_by=null;
        }
        jQuery.ajax({
                type:'GET',
                data:{
                    page_type: 'orders',
                    page_no:id,
                    search_query:search_query,
                    search_by:search_by
                },
                url:templateUrl,
                success: function(value) {
                    //console.log(value);
                    jQuery('#content').html('');
                    jQuery('#content').html(value);
                }
        })
    }


</script>
<!-- creating js functions -->