<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'wp_enqueue_scripts', 'abcfsl_script_enq_css', 21 );

function abcfsl_script_enq_css() {

    $obj = ABCFSL_Main();
    $ver = $obj->pluginVersion;

    wp_register_style('abcfsl-staff-list', ABCFSL_PLUGIN_URL . 'css/staff-list.css', array(), $ver, 'all');
    wp_enqueue_style('abcfsl-staff-list');

}
