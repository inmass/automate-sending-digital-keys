<?php

global $wpdb;
$types = $wpdb->prefix."asdk_keys_types";
$types_query = $wpdb->get_results("SELECT `title` FROM $types");

$templates = $wpdb->prefix."asdk_templates";
$templates_query = $wpdb->get_results("SELECT * FROM $templates");
?>

<form method="post" id="add_templates_form">
    <input type="hidden" name="form_type"  value="add_templates">

    <?php
    foreach($types_query as $type) {
        $template_query = $wpdb->get_results("SELECT * FROM $templates WHERE key_type = '$type->title'");
        ?>
        <div class="asdk-email-template-container">
            <h3><?php echo $type->title; ?></h3>
            <p>You can use both simple text and HTML</p>
            <p>Please use "<b style="color: red;">[THE_KEY]</b>" placeholder to determine where you will have your key on the text.</p>
            <textarea class="template_input" previous_value="<?php if(!empty($template_query)) {echo $template_query[0]->html;}?>" style="width: 100%;" name="<?php echo $type->title; ?>"  id="<?php echo $type->title; ?>" rows="10"><?php if(!empty($template_query)) {echo $template_query[0]->html;}?></textarea>
        </div>
        <?php
    }
    ?>
    <br>
    <p id="error"></p>
    <input type="submit" value="Save" class="button button-primary">
</form>


<script>

    let form = document.getElementById('add_templates_form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let values = {};
        let inputs = document.getElementsByClassName('template_input');
        // check if the textinput value is different from the previous_value attribute
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].value != inputs[i].getAttribute('previous_value')) {
                // check if the new value contains the placeholder ([THE_KEY])
                if (inputs[i].value.indexOf('[THE_KEY]') == -1) {
                    // ask the user if they want to proceed
                    if (!confirm(`The template for ${inputs[i].getAttribute('id')} does not contain the placeholder. Do you want to proceed?`)) {
                        return;
                    }
                }
                let template = inputs[i].value
                values[inputs[i].getAttribute('id')]=template;
            }
        }

        console.log(values);
        // log length of values
        console.log(Object.keys(values).length);
        if ( Object.keys(values).length > 0){
            jQuery.ajax({
                url:'<?= plugin_dir_url( __FILE__ ); ?>post_data.php',
                type:'POST',
                data:{
                    "templates": values,
                    "form_type": 'add_templates'
                },
                success:function(data) {
                    console.log(data);
                    if (data.includes('success')) {
                        alert('Successfully saved');
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].setAttribute('previous_value', inputs[i].value);
                        }
                    } else {
                        document.getElementById('error').innerHTML = data;
                    }
                }
            });
        }
    });

</script>