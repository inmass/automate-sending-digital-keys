<?php

global $wpdb;
$tablename = $wpdb->prefix."asdk_keys_types";

$types = $wpdb->get_results("SELECT * FROM $tablename");

?>

<div>
    <?php
    foreach ($types as $type) {
        echo $type->title;
    }
    ?>

</div>
<!-- redirect to add_key.php -->
<a href="<?php echo admin_url('admin.php?page=add-key-type'); ?>">Add new key type</a>




