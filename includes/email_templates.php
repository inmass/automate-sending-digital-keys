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
    // function to show the preview of the template
    function preview(element,key_type) {
        console.log(element);
        console.log(key_type);
        var template = document.getElementById(`${key_type}`).value;
        var preview = document.getElementById("preview_"+key_type);

        if (template.indexOf("'") != -1) {
            preview.innerHTML = "Please do not use single quotes (') in the text, it will break the email.";
        } else {
            preview .innerHTML = template;
        }

        preview.style.display = "block";

        // transform the element to hide the preview
        element.innerHTML = "Hide preview";
        element.className = "hide_preview_button";
        element.setAttribute( "onClick", `hide_preview(this,'${key_type}')` );
    }

    // function to hide the preview of the template
    function hide_preview(element,key_type) {
        var preview = document.getElementById("preview_"+key_type);
        preview.style.display = "none";

        // transform the element to show the preview
        element.innerHTML = "Preview template";
        element.className = "preview_button";
        element.setAttribute( "onClick", `preview(this,'${key_type}')` );
    }

    let form = document.getElementById('add_templates_form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let values = {};
        let inputs = document.getElementsByClassName('template_input');
        // check if the textinput value is different from the previous_value attribute
        for (let i = 0; i < inputs.length; i++) {
            if (inputs[i].value != inputs[i].getAttribute('previous_value')) {
                // check if the new value contains the placeholder ([THE_KEYS])
                if (inputs[i].value.indexOf('[THE_KEYS]') == -1) {
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