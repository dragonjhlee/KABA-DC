<?php

defined( 'ABSPATH' ) or exit;

/**
 * Check if form has a captcha field. If so, validate captcha.
 *
 * If captcha is invalid, add an error to the array of errors.
 *
 * @param array $errors
 * @param MC4WP_Form $form
 *
 * @return array
 */
function mc4wp_captcha_form_errors( $errors, MC4WP_Form $form ) {

	// only run if form has a captcha field
	if( ! isset( $form->raw_data['_has_captcha'] ) ) {
		return $errors;
	}

    $check = gglcptch_check();
	if( ! $check['response'] ) {
        // the error code references our form message
        $errors[] = 'invalid_captcha';
    }

	return $errors;
}

/**
 * Register a new form message for when the Captcha field is invalid.
 *
 * @param array $messages
 *
 * @return array
 */
function mc4wp_captcha_register_form_message( $messages ) {
	$messages['invalid_captcha'] = __( 'Please complete the CAPTCHA.', 'mc4wp-captcha' );


	/**
	 * The above code is a shorter version of the following code, which is also perfectly valid.
	 *
	 * $messages['invalid_captcha'] = array(
	 *      'type' => 'error',
	 *      'text' => __( 'Please complete the CAPTCHA.', 'mc4wp-captcha' );
	 * );
	 */

	return $messages;
}

/**
 * Register a new dynamic content tag: {captcha}
 *
 * When {captcha} is found in the form code, it will be replaced with the value of the 'replacement' key.
 *
 * @param array $tags
 * @return array
 */
function mc4wp_captcha_add_dynamic_content_tags( $tags ) {

	$tags['captcha'] = array(
		'description' => __( 'Replaced with the HTML for the Captcha field.', 'mc4wp-captcha' ),
		'replacement' => '<input type="hidden" name="_has_captcha" value="1" />' . gglcptch_display()
	);

	return $tags;
}

/**
 * Add a row to the table of form messages.
 *
 * MailChimp for WordPress will automatically save the value of the input field because of the `name` attribute.
 *
 * @param array $messages
 * @param MC4WP_Form $form
 */
function mc4wp_captcha_add_form_message_settings_row( $messages, MC4WP_Form $form ) {

	if( empty( $messages ) ) {
		$message = $form->get_message( 'invalid_captcha' );
	} else {
		// for BC with v3.x of MailChimp for WordPress
		$message = $messages['invalid_captcha'];
	}

	include dirname( __FILE__ ) . '/views/setting.php';
}

/**
 * Ignore the following fields which are only used internally by BWS Captcha
 *
 * @param $fields
 *
 * @return mixed
 */
function mc4wp_captcha_ignored_fields( $fields ) {
	return $fields + array( 'g-recaptcha-response', 'gglcptch_test_enable_js_field' );
}


function mc4wp_captcha_exclude_form_from_ajax_check( $selectors ) {
    $selectors[] = 'form.mc4wp-ajax';
    return $selectors;
}

function mc4wp_captcha_print_js() {
	?><script>try{ mc4wp.forms.on('submitted', function() { if(grecaptcha) { grecaptcha.reset(); } }); } catch(e) {}</script><?php
}
