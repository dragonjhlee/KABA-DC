<?php
/*
 * Version 0.0.2
 * Admin OK, Info, Error messages.
 */

//== ADMIN MESSAGES WP STYLE ==============================================
if ( !function_exists( 'abcfl_autil_msg_err' ) ){
function abcfl_autil_msg_err( $msg, $die=true ){
    echo abcfl_html_tag('div','', 'notice notice-error' );
    echo abcfl_html_tag_with_content( $msg, 'p', '' );
    echo abcfl_html_tag_end('div');
    if( $die ){ die; }
}}

if ( !function_exists( 'abcfl_autil_msg_ok' ) ){
function abcfl_autil_msg_ok( $msg='OK', $die=false ){
    echo abcfl_html_tag('div','', 'notice notice-success is-dismissible' );
    echo abcfl_html_tag_with_content( $msg, 'p', '' );
    echo abcfl_html_tag_end('div');
    if( $die ){ die; }
}}

if ( !function_exists( 'abcfl_autil_msg_info' ) ){
function abcfl_autil_msg_info( $msg, $die=false ){
    echo abcfl_html_tag('div','abcflInfo', 'abcflNotice abcflNoticeInfo' );
    echo abcfl_html_tag_with_content( $msg, 'p', '' );
    echo abcfl_html_tag_end('div');
    if( $die ){ die; }
}}
