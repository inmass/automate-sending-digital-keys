<?php
include('functions.php');

global $wpdb;
$tablename = $wpdb->prefix."asdk_keys";
$query = $wpdb->get_results("SELECT * FROM $tablename");
// get automated-sending-digital-keys assets directory
$assets_dir = plugin_dir_url( __FILE__ ).'assets/';
?>

<p class="search-box">
    <br>
    <label for="search_by">Search by</label>
    <select name="search_by" id="search_by">
        <option value="" selected disabled></option>
        <option value="key_type">Key type</option>
        <option value="activation_key">Key</option>
    </select>
    <input type="search" id="search_query" name="search_query" placeholder="Query here" value="" disabled>
    <br><br>
</p>

<div>
    <h1>Activation keys</h1>
    <div>
        <form method="post">
            <input type="hidden" name="PIDCHECK" value=1>
            <button type="submit">PID check keys</button>
            <br>
            <small>The PID check will check your keys and remove any that are invalid (invalid codes: 0xC004C060 and 0xC004C003)</small>
            <br>
            <small>The PID Check may sometimes run into problems, so you may as well want to check your keys manually if you encounter a problem.</small>
        </form>
    </div>
    <br>
    <table width='100%' border='1' class="wp-list-table widefat fixed striped pages " style='border-collapse: collapse;'>
        <thead>
            <tr>
                <th>Id</th>
                <th>Activation key</th>
                <th>Key type</th>
                <th>Microsft key</th>
                <th>Key count</th>
                <th>Used</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="content" >
            <?php key_per_page(1,40,null,null); ?>
        </tbody>
    </table>
    <div id="error"></div>
</div>

<a href="<?php echo admin_url('admin.php?page=add-key'); ?>">Add new key</a>



<!-- creating js functions -->
<script>
    let post_url = "<?= plugin_dir_url( __FILE__ ); ?>post_data.php";
    let get_url = "<?= plugin_dir_url( __FILE__ ); ?>get_data.php";
</script>
<script src="<?php echo $js_file ?>"></script>
<!-- creating js functions -->