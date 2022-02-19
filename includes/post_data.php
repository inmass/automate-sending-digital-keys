<?php

global $wpdb;
if ( ! defined('ABSPATH') ) {
    /** Set up WordPress environment */
  
    require($_SERVER['DOCUMENT_ROOT'] . '/Woocommerce test/wp-load.php');

    // require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}

global $wpdb;


if ($_POST['form_type'] == "add_key") {

    $table = $wpdb->prefix . "asdk_keys";
    $wpdb->insert(
        $table,
        array(
            'activation_key' => $_POST['activation_key'],
            'key_type' => $_POST['key_type'],
            'key_count' => $_POST['key_count'],
            'used' => 0
        )
    );
    echo "success";

} else if ($_POST['form_type'] == "add_key_type") {

    $table = $wpdb->prefix . "asdk_keys_types";
    $wpdb->insert(
        $table,
        array(
            // save title in upper case
            'title' => strtoupper($_POST['title'])
        )
    );
    echo "success";

}