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



<script>
    let post_url = "<?= plugin_dir_url( __FILE__ ); ?>post_data.php";
    let get_url = "<?= plugin_dir_url( __FILE__ ); ?>get_data.php";
</script>
<script src="<?php echo $js_file ?>"></script>