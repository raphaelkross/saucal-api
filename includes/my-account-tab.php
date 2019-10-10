<?php
/**
 * API Helpers
 *
 * @package SauCalAPI
 */

namespace SauCalAPI\MyAccountTab;

/**
 * Add custom endpoint.
 */
function add_endpoint() {
	add_rewrite_endpoint( 'saucal-api', EP_ROOT | EP_PAGES );
}
add_action( 'init', __NAMESPACE__ . '\add_endpoint' );

/**
 * Add query vars.
 *
 * @param array $vars The query vars.
 */
function add_query_vars( $vars ) {
	$vars[] = 'saucal-api';
	return $vars;
}
add_filter( 'query_vars', __NAMESPACE__ . '\add_query_vars', 0 );


/**
 * Add a new item to My Account Tabs.
 *
 * @param array $items The tabs.
 */
function add_tab( $items ) {
	$items['saucal-api'] = 'SAU/CAL API';
	return $items;
}
add_filter( 'woocommerce_account_menu_items', __NAMESPACE__ . '\add_tab' );

/**
 * Add tab content.
 */
function add_tab_content() {

	if ( is_user_logged_in() && \SauCalAPI\Utils\is_saucal_api() ) :
		// Call our action.
		do_action( 'saucal_api_before_form' );

		// Get data to display at field.
		$ids = get_the_author_meta( 'saucal-ids', get_current_user_id() );
		?>
		<h3>SAU/CAL API</h3>

		<div class="saucal-user-settings"><div class="loader"><?php esc_html_e( 'Loading Settings...', 'saucal-api' ); ?></div></div>

		<form class="saucal-form" action="" method="post">
			<?php wp_nonce_field( 'save_saucal_api', 'saucal_api_nonce' ); ?>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label><?php esc_html_e( 'IDs (comma-separated):', 'saucal-api' ); ?></label><br>
				<input type="text" name="saucal-ids" class="woocommerce-Input woocommerce-Input--text input-text" value="<?php echo esc_attr( $ids ); ?>">
			</p>
			<p>
				<button type="submit"><?php esc_html_e( 'Submit', 'saucal-api' ); ?></button>
			</p>
		</form>
		<?php
	endif;
}
add_action( 'woocommerce_account_saucal-api_endpoint', __NAMESPACE__ . '\add_tab_content' );

/**
 * Save Data.
 */
function save() {
	// Check nounce.
	if (
		isset( $_POST['saucal_api_nonce'] )
		&& wp_verify_nonce( $_POST['saucal_api_nonce'], 'save_saucal_api' )
	) {
		// Get the ids and save them.
		$ids = isset( $_POST['saucal-ids'] ) ? sanitize_text_field( $_POST['saucal-ids'] ) : '';

		$user_id = get_current_user_id();
		update_user_meta( $user_id, 'saucal-ids', $ids );

	}
}
add_action( 'saucal_api_before_form', __NAMESPACE__ . '\save' );
