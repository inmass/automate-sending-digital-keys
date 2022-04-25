<?php

global $wpdb;
$tablename = $wpdb->prefix."asdk_keys_types";
$query = $wpdb->get_results("SELECT `title` FROM $tablename");
?>
<div>
    <h1>Add new activation key</h1>
    <form action="<?= plugin_dir_url( __FILE__ ); ?>post_data.php" method="post" id="add_key">
        <input type="hidden" name="form_type"  value="add_key">
        <label for="key_type">Key type</label>
        <br>
        <select name="key_type" id="key_type" required>
            <option value="" selected disabled>---</option>
            <?php foreach ($query as $key) { ?>
                <option value="<?= $key->title ?>"><?= $key->title ?></option>
            <?php } ?>
        </select>
        <a href="<?php echo admin_url('admin.php?page=add-key-type'); ?>">Add new key type</a>
        <br><br>
        <label for="activation_key">Activation key</label>
        <br>
        <input type="text" name="activation_key" id="activation_key" required>
        <br><br>
        <label for="key_count">Number of times for the key to be used (type in -1 to use it with no count limit)</label>
        <br>
        <input type="number" name="key_count" id="key_count" step="1" required>
        <br><br>
        <input type="checkbox" name="is_microsoft_key" id="is_microsoft_key" checked='true'>
        <label for="is_microsoft_key">This is a Microsft key (This will make the key eligible for the PID check)</label>
        <br><br>
        <input type="submit" value="Add key">
    </form>
    <div id="error" style="color: red;"></div>
</div>


<script>
    let post_url = "<?= plugin_dir_url( __FILE__ ); ?>post_data.php";
    let get_url = "<?= plugin_dir_url( __FILE__ ); ?>get_data.php";
</script>
<script src="<?php echo $js_file ?>"></script>