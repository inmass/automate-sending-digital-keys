<?php
include('functions.php');

global $wpdb;
$keys = $wpdb->prefix."asdk_keys";
$query_keys = $wpdb->get_results("SELECT * FROM $keys");

$keys_types = $wpdb->prefix."asdk_keys_types";
$query_keys_types = $wpdb->get_results("SELECT * FROM $keys_types");

$keys_users = $wpdb->prefix."asdk_keys_users";
$query_keys_users = $wpdb->get_results("SELECT * FROM $keys_users ORDER BY sent_to DESC");
// getting to buyers
$buyers = array();
$emails = array();
foreach ($query_keys_users as $key_user) {
    if (!in_array($key_user->sent_to, $emails)) {
        $emails[] = $key_user->sent_to;
        $array = array(
            'email' => $key_user->sent_to,
            'count' => 1
        );
        $buyers[] = $array;
    } else {
        $key = array_search($key_user->sent_to, array_column($buyers, 'email'));
        // increment count
        $buyers[$key]['count'] += 1;
    }
} 
// order $buyers by count
array_multisort(array_column($buyers, 'count'), SORT_DESC, $buyers);
// getting to buyers
// getting to types sold
$types_counts = array();
$types = array();
foreach ($query_keys_users as $key_user) {
    if (!in_array($key_user->key_type, $types)) {
        $types[] = $key_user->key_type;
        $array = array(
            'type' => $key_user->key_type,
            'count' => 1
        );
        $types_counts[] = $array;
    } else {
        $key = array_search($key_user->key_type, array_column($types_counts, 'type'));
        // increment count
        $types_counts[$key]['count'] += 1;
    }
} 
array_multisort(array_column($types_counts, 'count'), SORT_DESC, $types_counts);
    // echo "<pre>";
    // var_dump($types_counts);
    // echo "</pre>";
// getting to types sold


?>

<div style="background-color: white; border:1px solid #c3c4c7; margin-top: 20px; padding: 20px; border-radius: 3px;">
    <h1>Activation keys count:</h1>
    <p>
        <?php
        $keys_count = 0;
        foreach($query_keys as $key){
            $keys_count++;
        }
        echo $keys_count;
        ?>
    </p>
    <a href="<?php echo admin_url('admin.php?page=add-key'); ?>">Add new key</a>
    <hr>
    <h1>Activation keys types:</h1>
    <p>
        <?php
        $keys_types_count = 0;
        foreach($query_keys_types as $key_type){
            $keys_types_count++;
        }
        echo $keys_types_count;
        ?>
    </p>
    <a href="<?php echo admin_url('admin.php?page=add-key-type'); ?>">Add new key type</a>
    <hr>
    <h1>Times ASDK was used:</h1>
    <p>
        <?php
        $keys_users_count = 0;
        foreach($query_keys_users as $key_user){
            $keys_users_count++;
        }
        echo $keys_users_count;
        ?>
    </p>
    <?php
       if ($keys_users_count) {
    ?>
    <hr>
    <h1>Top buyers:</h1>
    <table width='100%' border='1' class="wp-list-table widefat fixed striped pages " style='border-collapse: collapse;'>

        <tbody id="content" >
            <?php
            foreach ($buyers as $key => $buyer) {
                if ($key < 3) {
                    echo "<tr>";
                    echo "<td>".$buyer['email']."</td>";
                    echo "<td>".$buyer['count']."</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <h1>Top products:</h1>
    <table width='100%' border='1' class="wp-list-table widefat fixed striped pages " style='border-collapse: collapse;'>

        <tbody id="content" >
            <?php
            foreach ($types_counts as $key => $type) {
                if ($key < 3) {
                    echo "<tr>";
                    echo "<td>".$type['type']."</td>";
                    echo "<td>".$type['count']."</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <?php
       }
    ?>


</div>



<!-- creating js functions -->

<!-- creating js functions -->