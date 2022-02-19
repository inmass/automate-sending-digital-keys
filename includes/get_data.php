<?php

global $wpdb;
if ( ! defined('ABSPATH') ) {
    /** Set up WordPress environment */
  
    require($_SERVER['DOCUMENT_ROOT'] . '/Woocommerce test/wp-load.php');

    // require($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
}

include('functions.php');
global $wpdb;


if (isset($_GET['page_no'])) {
    key_per_page($_GET['page_no'],20,$_GET["search_query"],$_GET["search_by"]);
} else {
    key_per_page(1,20,$_GET["search_query"],$_GET["search_by"]);
}