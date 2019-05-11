<?php
/**
 * Custom post types setup
*/
if ( ! defined( 'ABSPATH' ) ) {exit;}

add_action( 'init', 'abcfsl_register_post_types', 100 );

//----------------------------------------
function abcfsl_register_post_types() {

    $slug = 'edit.php?post_type=cpt_staff_lst_item';

    register_post_type( 'cpt_staff_lst_item', abcfsl_setup_post_type_sm( $slug ) );
    register_post_type( 'cpt_staff_lst', abcfsl_setup_post_type_st( $slug ) );
}

function abcfsl_setup_post_type_sm( $slug ) {

    $lbls = array(
        'name'               => __( 'Staff Members', 'staff-list' ), //Sliders table
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Staff Member', 'staff-list' ),
        'edit_item'          => __( 'Staff Member', 'staff-list' ),
        'new_item'           => __( 'New'),
        'all_items'          => __( 'Staff Members', 'staff-list' ), //Main menu label
        'search_items'       => __( 'Search', 'staff-list' ),
        'not_found'          => __( 'No records found', 'staff-list' ),
        'not_found_in_trash' => __( 'No records found in the Trash', 'staff-list' )
    );

    $args = array(
            'labels'        => $lbls,
            'description'   => '',
            'public'        => false,
            'hierarchical'  => false,
            'supports'      => array( 'title' ),
            'has_archive'   => false,
            'show_ui'       => true,
            'show_in_menu'  => $slug
    );

    return $args;
}

function abcfsl_setup_post_type_st( $slug ) {

    $lbls = array(
        'menu_name'	     => __( 'Menu Staff', 'staff-list' ),
        'name'               => __( 'Staff Templates', 'staff-list' ),
        'add_new'            => __( 'Add New' ),
        'add_new_item'       => __( 'Staff Template', 'staff-list' ),
        'edit_item'          => __( 'Staff Template', 'staff-list' ),
        'new_item'           => __( 'New'),
        'all_items'          => __( 'Staff Templates', 'staff-list' ), //Main menu label
        'search_items'       => __( 'Search', 'staff-list' ),
        'not_found'          => __( 'No records found', 'staff-list' ),
        'not_found_in_trash' => __( 'No records found in the Trash', 'staff-list' )
    );

    $args = array(
        'labels'        => $lbls,
        'description'   => '',
        'public'        => false,
        'hierarchical'  => false,
        'supports'      => array( 'title' ),
        'has_archive'   => false,
        'show_ui'       => true,
        'show_in_menu'  => $slug
    );

    return $args;
}





