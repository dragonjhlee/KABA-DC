<?php
/**
 * Utility functions. Used by all plugins.
 * Version 2
*/
//===  MESSAGES  =========================================================
if ( !function_exists( 'abcfl_util_div_err_msg' ) ){
    function abcfl_util_div_err_msg($msg1, $msg2=''){

        if(!abcfl_html_isblank($msg1)){ $msg1 = '<p>' . $msg1 . '</p>'; }
        if(!abcfl_html_isblank($msg2)){ $msg2 = '<p>' . $msg2 . '</p>'; }

        $msg = $msg1 . $msg2;
        if(abcfl_html_isblank($msg)){ return; }
        echo ('<div class="abcfDivErrMsg">' . $msg . '</div>');
    }
}

if ( !function_exists( 'abcfl_util_msg_ok' ) ){
    function abcfl_util_msg_ok() {
        echo '<div class="wrap"><div id="abcfalOK" class="updated" style="line-height: 250%;">&nbsp; OK &nbsp;</div></div>';
    }
}

if ( !function_exists( 'abcfl_util_msg_info' ) ){
    function abcfl_util_msg_info($txt) { echo '<div class="wrap"><div class="updated fade" id="message"><p>' . $txt . '</p></div></div>' . "\n"; }
}

if ( !function_exists( 'abcfl_util_msg_err' ) ){
    function abcfl_util_msg_err($txt) { echo '<div class="wrap"><div class="error" id="error"><p>' . $txt . '</p></div></div>'; }
}
//=========================================================================
//Returns empty string or custom CSS URL if custom file exists.
if ( !function_exists( 'abcfl_util_custom_css_url' ) ){
function abcfl_util_custom_css_url( $fileName ) {

    if(empty($fileName)){ return ''; }

    $url = '';
    $custom = trailingslashit( 'abcfolio') . $fileName ;
    $uploadDir = wp_upload_dir();
    $fileQPat = trailingslashit( $uploadDir['basedir'] ) . $custom;
    $customFileURL = trailingslashit( $uploadDir['baseurl'] ) . $custom;

    if ( file_exists( $fileQPat )) { $url = $customFileURL; }
    return $url;
}}
