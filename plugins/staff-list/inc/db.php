<?php

function abcfsl_db_staff_member_ids( $parentID, $qryOptns ) {
    global $wpdb;
        $postIDs = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID
        FROM $wpdb->posts
        WHERE post_parent = %d
        AND post_status = 'publish'
        ORDER BY menu_order ASC", $parentID ));

    return $postIDs;
}


function abcfsl_db_image_meta($postID) {
    global $wpdb;
    $meta = $wpdb->get_col(
    "SELECT meta_value
    FROM $wpdb->postmeta
    WHERE post_id = ' . $postID .
    ' AND meta_key = '_wp_attachment_metadata'");
    return $meta;
}

//-- PRETTY -----------------------------------------------------
function abcfsl_db_post_id_by_pretty( $metaValue ) {

    if( empty( $metaValue ) ) { return 0; }

    global $wpdb;
    $postID = $wpdb->get_var( $wpdb->prepare(
        "SELECT pm.post_id
        FROM $wpdb->postmeta pm
        JOIN $wpdb->posts p ON  pm.post_id = p.ID
        WHERE p.post_status = 'publish'
        AND pm.meta_key = '_pretty'
        AND pm.meta_value = %s;", $metaValue ) );

    if( is_null($postID) ) { return 0; }
    return $postID;
}

function abcfsl_db_spg_title_by_pretty( $metaValue ) {

    $postID = abcfsl_db_post_id_by_pretty( $metaValue );
    if( is_null($postID) || $postID == 0 ) { return ''; }

    global $wpdb;
    $sPgTitle = $wpdb->get_var( $wpdb->prepare(
            "SELECT meta_value
            FROM $wpdb->postmeta
            WHERE meta_key = '_sPgTitle'
            AND post_id = %d;", $postID ) );

    return $sPgTitle;
}

function abcfsl_db_staff_member( $staffID ) {

    global $wpdb;

    $postID = $wpdb->get_col( $wpdb->prepare(
        "SELECT ID
        FROM $wpdb->posts
        WHERE ID = %d
        AND post_status = 'publish'", $staffID ));

    return $postID;
}