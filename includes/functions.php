<?php

function key_per_page($page, $count_per_page, $search_query = null, $search_by = null)
{
    global $wpdb;
    $tablename = $wpdb->prefix."asdk_keys";

    if ($page == 0) {
        $page = 1;
    }
    $total_records_per_page = $count_per_page;
    $offset = ($page - 1) * $total_records_per_page;

    if ($search_query == null) {
        $result_count = $wpdb->get_results(
            "SELECT COUNT(*) As total_records FROM  $tablename;"
        );
    } else {
        $result_count = $wpdb->get_results(
            "SELECT COUNT(*) As total_records FROM  $tablename WHERE lower(`$search_by`) LIKE lower('%".$search_query."%')"
        );
    }

    if ($result_count) {
        $total_records = $result_count[0]->total_records;
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
    } else {
        $total_no_of_pages = 1;
    }

    if ($search_query == null) {
        $entriesList = $wpdb->get_results(
            "SELECT * FROM $tablename order by -id asc LIMIT $offset, $total_records_per_page"
        );
    } else {
        $entriesList = $wpdb->get_results(
            "SELECT * FROM $tablename  WHERE lower(`$search_by`) LIKE lower('%$search_query%') order by -id asc LIMIT $offset, $total_records_per_page"
        );
    }

    $output = "";
    if (count($entriesList) > 0) {
        $count = 1;
        foreach ($entriesList as $entry) {
            $id = $entry->id;
            $activation_key = $entry->activation_key;
            $key_type = $entry->key_type;
            $key_count = $entry->key_count;
            $used = $entry->used;

            $output .=
                "<tr>
                    <td>" .$id ."</td>
                    <td>" .$activation_key ."</td>
                    <td>" .$key_type ."</td>
                    <td>" .$key_count ."</td>
                    <td>" .$used ."</td>
                </tr>
            ";
            $count++;
        }
        $output .= '
            <tr>
                <td colspan="5">
                    <ul class="pagination" style="display:flex;justify-content: space-between;">
                        <li >
        ';
        $prev = $page - 1;
        if ($page <= 1) {
            $class = " disabled";
        } else {
            $class = "";
        }
        $output .= "<button  type='button' onclick='get_page($prev)'  class='thickbox button button-primary $class'>Précédent</button>";

        $output .=
            '
                <li>
                    <div style="padding: 10px 20px 0px;">
                        <strong>Page  ' .$page ." sur " .$total_no_of_pages .' </strong>
                    </div>
                </li>
            ';
        if ($page >= $total_no_of_pages) {
            $class = "disabled";
        } else {
            $class = "";
        }
        $next = $page + 1;
        $output .=
            '<li> <button  type="button" onclick="get_page(' .$next .')"   class="thickbox button button-primary ' .$class .'" >Suivant</button>';

        if ($page < $total_no_of_pages) {
            $output .=
                '<button type="button" onclick="get_page(' .$total_no_of_pages .')"  class="thickbox button button-primary">Dernière &rsaquo;&rsaquo;</button>';
        } else {
            $output .=
                '<button type="button"  class="thickbox button button-primary disabled">Dernière &rsaquo;&rsaquo;</button>';
        }
        $output .= "</li></ul></td></tr>";
    } else {
        $output .= "
            <tr>
                <td colspan='5'>No record found</td>
            </tr>
        ";
    }

    echo $output;
}

function key_types_per_page($page, $count_per_page, $search_query = null, $search_by = null)
{
    global $wpdb;
    $tablename = $wpdb->prefix."asdk_keys_types";
    $keys_table = $wpdb->prefix."asdk_keys";

    if ($page == 0) {
        $page = 1;
    }
    $total_records_per_page = $count_per_page;
    $offset = ($page - 1) * $total_records_per_page;

    if ($search_query == null) {
        $result_count = $wpdb->get_results(
            "SELECT COUNT(*) As total_records FROM  $tablename;"
        );
    } else {
        $result_count = $wpdb->get_results(
            "SELECT COUNT(*) As total_records FROM  $tablename WHERE lower(`title`) LIKE lower('%".$search_query."%')"
        );
    }

    if ($result_count) {
        $total_records = $result_count[0]->total_records;
        $total_no_of_pages = ceil($total_records / $total_records_per_page);
    } else {
        $total_no_of_pages = 1;
    }

    if ($search_query == null) {
        $entriesList = $wpdb->get_results(
            "SELECT * FROM $tablename order by -id asc LIMIT $offset, $total_records_per_page"
        );
    } else {
        $entriesList = $wpdb->get_results(
            "SELECT * FROM $tablename  WHERE lower(`title`) LIKE lower('%$search_query%') order by -id asc LIMIT $offset, $total_records_per_page"
        );
    }

    $output = "";
    if (count($entriesList) > 0) {
        $count = 1;
        foreach ($entriesList as $entry) {
            $id = $entry->id;
            $title = $entry->title;
            $keys_count = $wpdb->get_results(
                "SELECT COUNT(*) AS total_keys FROM $keys_table WHERE key_type = '$title'"
            );

            $output .=
                "<tr>
                    <td>" .$id ."</td>
                    <td>" .$title ."</td>
                    <td><a href='admin.php?page=activation-keys&to_redirect=filter_by_key_type&page_type=activation_keys&search_query=".$title."&search_by=key_type'>" .$keys_count[0]->total_keys."</a></td>
                </tr>
            ";
            $count++;
        }
        $output .= '
            <tr>
                <td colspan="3">
                    <ul class="pagination" style="display:flex;justify-content: space-between;">
                        <li >
        ';
        $prev = $page - 1;
        if ($page <= 1) {
            $class = " disabled";
        } else {
            $class = "";
        }
        $output .= "<button  type='button' onclick='get_page($prev)'  class='thickbox button button-primary $class'>Précédent</button>";

        $output .=
            '
                <li>
                    <div style="padding: 10px 20px 0px;">
                        <strong>Page  ' .$page ." sur " .$total_no_of_pages .' </strong>
                    </div>
                </li>
            ';
        if ($page >= $total_no_of_pages) {
            $class = "disabled";
        } else {
            $class = "";
        }
        $next = $page + 1;
        $output .=
            '<li> <button  type="button" onclick="get_page(' .$next .')"   class="thickbox button button-primary ' .$class .'" >Suivant</button>';

        if ($page < $total_no_of_pages) {
            $output .=
                '<button type="button" onclick="get_page(' .$total_no_of_pages .')"  class="thickbox button button-primary">Dernière &rsaquo;&rsaquo;</button>';
        } else {
            $output .=
                '<button type="button"  class="thickbox button button-primary disabled">Dernière &rsaquo;&rsaquo;</button>';
        }
        $output .= "</li></ul></td></tr>";
    } else {
        $output .= "
            <tr>
                <td colspan='5'>No record found</td>
            </tr>
        ";
    }

    echo $output;
}

?>
