<div>
    <h1>Add new key type</h1>
    <form action="<?= plugin_dir_url( __FILE__ ); ?>post_data.php" method="post" id="add_key_type">
        <input type="hidden" name="form_type"  value="add_key_type">
        <label for="title">Title</label>
        <br>
        <input type="text" name="title" id="title" required>
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