<?php
/**
 * Frontend
 *
 * @package SauCalAPI
 */

namespace SauCalAPI\Frontend;

/**
 * Enqueue scripts.
 */
function enqueue_custom_scripts() {
	wp_register_script( 'saucal-main', SAUCAL_API_URL . '/assets/scripts/main.js', array( 'jquery' ), SAUCAL_API_VERSION, true );

	wp_localize_script(
		'saucal-main',
		'wpApiSettings',
		array(
			'root'      => esc_url_raw( rest_url() ),
			'nonce'     => wp_create_nonce( 'wp_rest' ),
			'logged_in' => is_user_logged_in(),
		)
	);

	wp_enqueue_script( 'saucal-main' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_custom_scripts' );
