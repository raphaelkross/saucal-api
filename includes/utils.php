<?php
/**
 * Utils
 *
 * @package SauCalAPI
 */

namespace SauCalAPI\Utils;

/**
 * Check if is SAUCAL API page.
 *
 * @return bool
 */
function is_saucal_api() {
	global $wp;

	$page_id = wc_get_page_id( 'myaccount' );

	return ( $page_id && is_page( $page_id ) && isset( $wp->query_vars['saucal-api'] ) );
}
