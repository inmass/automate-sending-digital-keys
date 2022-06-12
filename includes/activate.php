<?php

function extract_domain($domain)
{

    // remove "/" at the end of $domain if found
    if (substr($domain, -1) == "/") {
        $domain = substr($domain, 0, -1);
    }

    if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches))
    {
        return $matches['domain'];
    } else {
        return parse_url($domain);
    }
}


global $wpdb;
$tablename = $wpdb->prefix."asdk_keys_types";
$query = $wpdb->get_results("SELECT `title` FROM $tablename");
?>
<div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <h1>Welcome to Automate Sending Digital Keys!</h1>
    <h1>Please type in your activation key below.</h1>
    <form  method="post" id="activate">
        <label for="activation_key">Activation key</label>
        <br>
        <!-- input with long bootstrap class -->

        <input type="text" class="form-control" name="activation_key" id="activation_key" required style="width: 350px;">
        <br><br>
        <input id="submit_btn" type="submit" value="Submit">
        <p id="activating_text" style="display: none;">Activating...</p>
    </form>
    <div id="error" style="color: red;"></div>
</div>

<script src="https://unpkg.com/imask"></script>
<script>
    let full_domain = "<?php echo get_site_url(); ?>";
    let domain_name = "<?php echo extract_domain(get_site_url()); ?>";
    let post_url = "<?= plugin_dir_url( __FILE__ ); ?>post_data.php";
</script>
<script src="<?php echo $js_file ?>"></script>