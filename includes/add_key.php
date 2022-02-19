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
        <br><br>
        <label for="activation_key">Activation key</label>
        <br>
        <input type="text" name="activation_key" id="activation_key" required>
        <br><br>
        <label for="key_count">Key count</label>
        <br>
        <input type="number" name="key_count" id="key_count" step="1" min="1" value="1" required>
        <br><br>
        <input type="submit" value="Add key">
    </form>
</div>


<script>

    let form = document.getElementById('add_key');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let key_type = document.getElementById('key_type').value;
        let activation_key = document.getElementById('activation_key').value;
        let key_count = document.getElementById('key_count').value;
        let formData = new FormData(form);
        formData.append('form_type', 'add_key');
        formData.append('key_type', key_type);
        formData.append('activation_key', activation_key);
        formData.append('key_count', key_count);
        jQuery.ajax({
            type:'POST',
            data:formData,
            url:'<?= plugin_dir_url( __FILE__ ); ?>post_data.php',
            processData: false,
            contentType: false,
            success:function(data) {
                console.log(data);
                if (data == 'success') {
                    window.location.href = 'admin.php?page=activation-keys';
                }
            }
        });
    });

</script>