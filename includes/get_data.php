<?php

global $wpdb;
if ( ! defined('ABSPATH') ) {
    /** Set up WordPress environment */
  
    require($_SERVER['DOCUMENT_ROOT'] . '/Woocommerce test/wp-load.php');

    // require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}

include('functions.php');
global $wpdb;


if ($_GET['page_type'] == 'activation_keys') {
    if (isset($_GET['page_no'])) {
        key_per_page($_GET['page_no'],40,$_GET["search_query"],$_GET["search_by"]);
    } else {
        key_per_page(1,40,$_GET["search_query"],$_GET["search_by"]);
    }
} else if ($_GET['page_type'] == 'keys_types') {
    if (isset($_GET['page_no'])) {
        key_types_per_page($_GET['page_no'],40,$_GET["search_query"]);
    } else {
        key_types_per_page(1,40,$_GET["search_query"]);
    }
    #
} else if ($_GET['page_type'] == 'orders') {
    if (isset($_GET['page_no'])) {
        orders_per_page($_GET['page_no'],40,$_GET["search_query"],$_GET["search_by"]);
    } else {
        orders_per_page(1,40,$_GET["search_query"],$_GET["search_by"]);
    }
}