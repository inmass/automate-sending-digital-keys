<?php
include('functions.php');

global $wpdb;
$tablename = $wpdb->prefix."asdk_keys";
$query = $wpdb->get_results("SELECT * FROM $tablename");
?>

<p class="search-box">
    <br>
    <input type="search" id="search_query" name="search_query" placeholder="Search by title" value="">
    <br><br>
</p>

<div>
    <h1>Activation keys types</h1>
    <table width='100%' border='1' class="wp-list-table widefat fixed striped pages " style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Keys count</th>
                <th>Products with this type</th>
            </tr>
        </thead>

        <tbody id="content" >
            <?php key_types_per_page(1,20,null); ?>
        </tbody>
    </table>
</div>

<a href="<?php echo admin_url('admin.php?page=add-key-type'); ?>">Add new key type</a>


<script>
    let post_url = "<?= plugin_dir_url( __FILE__ ); ?>post_data.php";
    let get_url = "<?= plugin_dir_url( __FILE__ ); ?>get_data.php";
</script>
<script src="<?php echo $js_file ?>"></script>