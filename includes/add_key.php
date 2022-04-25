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

    let form = document.getElementById('add_key');
    form.addEventListener('submit', function(e) {
        document.getElementById('error').innerHTML = "";
        e.preventDefault();
        let key_type = document.getElementById('key_type').value;
        let activation_key = document.getElementById('activation_key').value;
        let key_count = document.getElementById('key_count').value;
        if (key_count == "") {
            key_count = null;
        }
        let is_microsoft_key_checked = document.getElementById('is_microsoft_key').checked;
        let is_microsoft_key;
        if (is_microsoft_key_checked) {
            is_microsoft_key = 1;
        } else {
            is_microsoft_key = 0;
        }
        let formData = new FormData(form);
        formData.append('form_type', 'add_key');
        formData.append('key_type', key_type);
        formData.append('activation_key', activation_key);
        formData.append('key_count', key_count);
        formData.append('is_microsoft_key', is_microsoft_key);
        jQuery.ajax({
            type:'POST',
            data:formData,
            url:'<?= plugin_dir_url( __FILE__ ); ?>post_data.php',
            processData: false,
            contentType: false,
            success:function(data) {
                console.log(data);
                if (data.includes('success')) {
                    window.location.href = 'admin.php?page=activation-keys';
                } else {
                    document.getElementById('error').innerHTML = data;
                }
            }
        });
    });

</script>