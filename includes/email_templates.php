<?php

global $wpdb;
$types = $wpdb->prefix."asdk_keys_types";
$types_query = $wpdb->get_results("SELECT `title` FROM $types");

$templates = $wpdb->prefix."asdk_templates";
$templates_query = $wpdb->get_results("SELECT * FROM $templates");
?>

<h1>You can use both simple text and HTML</h1>
<hr>
<form method="post" id="add_templates_form">
    <input type="hidden" name="form_type"  value="add_templates">
    
    <?php
    foreach($types_query as $type) {
        $template_query = $wpdb->get_results("SELECT * FROM $templates WHERE key_type = '$type->title'");
        ?>
        <div class="asdk-email-template-container">
            <h3><?php echo $type->title; ?></h3>
            <!-- WHAT IS THE NAME OF ' -->
            <p>Please use "<b style="color: green;">[THE_KEYS]</b>" placeholder to determine where you will have your key on the text.</p>
            <p>Please use "<b style="color: green;">[THE_PRODUCT]</b>" placeholder to determine where you will have your product name on the text.</p>
            <p><b style="color: red;">DO NOT USE SINGLE QUOTES (')</b> in the text, it will break the email. Use double quotes (") instead.</p>
            <textarea class="template_input" previous_value='<?php if(!empty($template_query)) {echo stripcslashes($template_query[0]->html);}?>' style="width: 100%;" name="<?php echo $type->title; ?>"  id="<?php echo $type->title; ?>" rows="10"><?php if(!empty($template_query)) {echo stripcslashes($template_query[0]->html);}?></textarea>
            <div id="preview_<?php echo $type->title; ?>" style="display: none; padding: 10px; background-color: white; border: 1px solid #8c8f94; border-radius: 4px">
                <?php
                    if(!empty($template_query)) {
                        echo stripcslashes($template_query[0]->html);
                    }
                    ?>
            </div>
            <a class="preview_button" onclick="preview(this,'<?php echo $type->title; ?>')" style="cursor: pointer;">Show preview</a>
        </div>
        <hr>
        <?php
    }
    ?>
    <br>
    <p id="error"></p>
    <input type="submit" value="Save" class="button button-primary">
</form>

<script>
    let post_url = "<?= plugin_dir_url( __FILE__ ); ?>post_data.php";
    let get_url = "<?= plugin_dir_url( __FILE__ ); ?>get_data.php";
</script>
<script src="<?php echo $js_file ?>"></script>