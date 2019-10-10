<?php
/**
 * API
 *
 * @package SauCalAPI
 */

namespace SauCalAPI\API;

/**
 * SAU/CAL API REST Controller.
 */
class SauCalAPI_Controller extends \WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'saucal/v' . $version;

		register_rest_route(
			$namespace,
			'/external-api',
			array(
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'external_api' ),
					'permission_callback' => array( $this, 'permissions_check' ),
				),
			)
		);

	}

	/**
	 * Check if a given request has access manage the item.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|bool
	 */
	public function permissions_check( $request ) {
		// @TODO: validate if user is logged on.
		return true;
	}

	/**
	 * Make external request.
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 * @return WP_Error|WP_REST_Request
	 */
	public function external_api( $request ) {
		// Get current user ID.
		// @TODO: current user.
		$user_id = '1';
		$ids_raw = get_the_author_meta( 'saucal-ids', $user_id );

		if ( ! empty( $ids_raw ) ) {
			// Build the array of IDs.
			$ids  = explode( ',', $ids_raw );
			$body = '';

			// Cache key.
			$key = 'saucal_api_external_' . $user_id . '_' . $ids_raw;

			// Get any existing copy of our transient data.
			if ( false === \get_transient( $key ) ) {
				// Make external request.
				$response = wp_remote_get( 'https://httpbin.org/json' );

				if ( 200 === wp_remote_retrieve_response_code( $response ) ) {
					$body = json_decode( wp_remote_retrieve_body( $response ) );
				}

				set_transient( $key, $body, 12 * HOUR_IN_SECONDS );
			} else {
				$body = \get_transient( $key );
			}

			return new \WP_REST_Response( $body, 200 );
		}

		return new \WP_REST_Response( '', 400 );
	}
}

/**
 * Register the REST route.
 */
add_action(
	'rest_api_init',
	function() {
		$controller = new SauCalAPI_Controller();
		$controller->register_routes();

	}
);
