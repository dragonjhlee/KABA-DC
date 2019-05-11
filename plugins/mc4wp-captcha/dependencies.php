<?php

// is MailChimp for WordPress 3.0 installed?
if( ! defined( 'MC4WP_VERSION' ) || version_compare( MC4WP_VERSION, '3.0', '<' ) ) {
	return false;
}

// is Google Captcha plugin by BestWebSoft installed?
// https://wordpress.org/plugins/google-captcha/
if( ! function_exists( 'gglcptch_display' ) ) {
	return false;
}

// finally, return true
return true;
