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
    if (isset($_POST['key_count'])) {
        $key_count = $_POST['key_count'];
    } else {
        $key_count = -1;
    }
    $reult = $wpdb->insert(
        $table,
        array(
            'activation_key' => $_POST['activation_key'],
            'key_type' => $_POST['key_type'],
            'key_count' => $key_count,
        )
    );
    if ($reult) {
        $response = "success";
    } else {
        $response = "This key already exists, try another one.";
    }
    echo $response;

} else if ($_POST['form_type'] == "add_key_type") {

    $table = $wpdb->prefix . "asdk_keys_types";
    $result = $wpdb->insert(
        $table,
        array(
            // save title in upper case
            'title' => strtoupper($_POST['title'])
        )
    );
    if ($result) {
        $response = "success";
    } else {
        $response = "This type already exists, try another one.";
    }
    echo $response;

} else if ($_POST['form_type'] == "edit_key") {
    $table = $wpdb->prefix . "asdk_keys";
    // if ($_POST['used'] == )
    $result = $wpdb->update(
        $table,
        array(
            'key_count' => $_POST['count'],
            'used' => boolval($_POST['used']),
        ),
        array(
            'id' => $_POST['key_id']
        )
    );
    if ($result) {
        $response = "success";
    } else {
        $response = $result;
    }
    echo $response;
} else if ($_POST['form_type'] == "add_templates") {
    $table = $wpdb->prefix . "asdk_templates";
    $templates = $_POST['templates'];
    
    if (!empty($templates)) {
        foreach ($templates as $key => $value) {
            $query = $wpdb->get_results("SELECT * FROM $table WHERE key_type = '$key'");
            if (empty($query)) {
                $result = $wpdb->insert(
                    $table,
                    array(
                        'key_type' => $key,
                        'html' => $value
                    )
                );
            } else {
                $result = $wpdb->update(
                    $table,
                    array(
                        'html' => $value
                    ),
                    array(
                        'key_type' => $key
                    )
                );
            }
        }
    }

    if ($result) {
        $response = "success";
    } else {
        $response = $result;
    }
    echo $response;
}