<?php 
/*
Plugin Name: Automate sending digital keys
Plugin URI: https://github.com/inmass/asdk
Description: Automate sending digital keys
Version: 1.0.0
Author: iinmass
Author URI: https://iinmass.com
Text Domain: asdk
Generated By: http://ensuredomains.com
*/

function asdk_callback()
{
    add_menu_page( "Auto send activation keys", "Auto send activation keys", "manage_options", "auto-send-activation-keys", "dashboard","dashicons-portfolio", 4);
    add_submenu_page("auto-send-activation-keys","Dashboard","Dashboard","manage_options","auto-send-activation-keys","dashboard");
    add_submenu_page("auto-send-activation-keys","Activation keys","Activation keys","manage_options","activation-keys","activation_keys");
    add_submenu_page("auto-send-activation-keys","Add new key","Add new key","manage_options","add-key","add_key");
    add_submenu_page("auto-send-activation-keys","Keys types","Keys types","manage_options","keys-types","keys_types");
    add_submenu_page("auto-send-activation-keys","Add new key type","Add new key type","manage_options","add-key-type","add_key_type");
}

add_action("admin_menu","asdk_callback");



function dashboard()
{
    include "includes/dashboard.php";
}

function activation_keys()
{
    include "includes/activation_keys.php";
}

function add_key()
{
    include "includes/add_key.php";
}

function keys_types()
{
    include "includes/keys_types.php";
}

function add_key_type()
{
    include "includes/add_key_type.php";
}






//////////////////////////////////////////////////
register_activation_hook(__FILE__,"createtable");
register_activation_hook(__FILE__,"createtable_sec");
register_activation_hook(__FILE__,"createtable_third");
function createtable()
{
    # code...
    
    global $wpdb;
    $plugin_name_db_version = '1.0.0';
    $table_name = $wpdb->prefix . "asdk_keys";
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                activation_key varchar(255) NULL,
                key_type varchar(255) NULL,
                key_count int(11) NULL,
                used BIT DEFAULT 0 NOT NULL
            ) $charset_collate;";
    
    // $wpdb->query($sql);
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function createtable_sec()
{
    # code...
    
    global $wpdb;
    $plugin_name_db_version = '1.0.0';
    $table_name = $wpdb->prefix . "asdk_keys_users"; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            activation_key varchar(255) NULL,
            sent_to BIT DEFAULT 0 NOT NULL,
            sell_date DATETIME NULL
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
function createtable_third()
{
    # code...
    
    global $wpdb;
    $plugin_name_db_version = '1.0.0';
    $table_name = $wpdb->prefix . "asdk_keys_types"; 
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            title varchar(255) NULL
        ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


register_deactivation_hook(__FILE__,"dropTable_one");
register_deactivation_hook(__FILE__,"dropTable_two");
register_deactivation_hook(__FILE__,"dropTable_three");

function dropTable_one()
{
    global $wpdb;
    # code...
    $table_name = $wpdb->prefix . "asdk_keys";
    $sql = "DROP TABLE IF EXISTS $table_name";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}
function dropTable_two()
{
    global $wpdb;
    # code...
    $table_name = $wpdb->prefix . "asdk_keys_users";

    $sql = "DROP TABLE IF EXISTS $table_name";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}
function dropTable_three()
{
    global $wpdb;
    # code...
    $table_name = $wpdb->prefix . "asdk_keys_types";

    $sql = "DROP TABLE IF EXISTS $table_name";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta( $sql );
}