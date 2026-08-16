<?php
/**
 * Contact form AJAX handler.
 *
 * Backs the `#contact-form` markup (see front-page.html / the mockup's
 * #contact-form section) submitted via fetch() from assets/js/main.js's
 * `contactForm` IIFE. Handles both logged-in and logged-out (nopriv)
 * visitors since the contact form is public-facing.
 *
 * Nonce action: 'tj_contact_form_nonce'
 * Recipient constant: TJ_CONTACT_RECIPIENT — defined elsewhere in
 * functions.php (e.g. define('TJ_CONTACT_RECIPIENT', 'tajim.tajwar@gmail.com')).
 * This file only references the constant, it does not define it.
 *
 * @package Tajwar_Tajim
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle the contact form AJAX submission.
 *
 * Verifies the nonce, sanitizes/validates the posted fields, and — on
 * success — emails TJ_CONTACT_RECIPIENT via wp_mail() with a Reply-To
 * header set to the visitor's own address so replying goes straight to them.
 */
function tj_handle_contact_form() {
	check_ajax_referer( 'tj_contact_form_nonce', 'nonce' );

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$subject = isset( $_POST['subject'] ) ? sanitize_text_field( wp_unslash( $_POST['subject'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( '' === $name ) {
		wp_send_json_error( array( 'message' => 'Please enter your name.' ) );
	}

	if ( '' === $email || ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ) );
	}

	if ( '' === $subject ) {
		wp_send_json_error( array( 'message' => 'Please enter a subject.' ) );
	}

	if ( '' === $message ) {
		wp_send_json_error( array( 'message' => 'Please enter a message.' ) );
	}

	$mail_subject = sprintf( '[Contact Form] %s', $subject );

	$mail_body  = "You've received a new message from the contact form on your site.\n\n";
	$mail_body .= "Name: {$name}\n";
	$mail_body .= "Email: {$email}\n\n";
	$mail_body .= "Message:\n{$message}\n";

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail( TJ_CONTACT_RECIPIENT, $mail_subject, $mail_body, $headers );

	if ( ! $sent ) {
		wp_send_json_error( array( 'message' => 'Something went wrong sending your message. Please try again or email me directly.' ) );
	}

	wp_send_json_success( array( 'message' => "Thanks! Your message has been sent — I'll reply within 1–2 business days." ) );
}
add_action( 'wp_ajax_tj_contact_form', 'tj_handle_contact_form' );
add_action( 'wp_ajax_nopriv_tj_contact_form', 'tj_handle_contact_form' );

/**
 * Localize the contact form's AJAX URL + nonce onto the 'tj-main' script
 * handle (assets/js/main.js, registered/enqueued elsewhere in
 * functions.php). Hooked at a late priority on wp_enqueue_scripts so it
 * can safely assume 'tj-main' has already been registered by the time
 * this runs.
 */
function tj_localize_contact_form_script() {
	wp_localize_script(
		'tj-main',
		'tjContactForm',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'tj_contact_form_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'tj_localize_contact_form_script', 20 );
