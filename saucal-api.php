<?php
/**
 * SAU/CAL API
 *
 * @package     SauCalAPI
 * @author      Rafael Angeline
 * @copyright   2016 Rafael Angeline
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: SAU/CAL API
 * Plugin URI:  http://saucal.com
 * Description: Example of external API request and JS interface.
 * Version:     1.0.0
 * Author:      Rafael Angeline
 * Author URI:  https://rafaelangeline.com
 * Text Domain: plugin-name
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

// Useful global constants.
define( 'SAUCAL_API_VERSION', '1.0.0' );
define( 'SAUCAL_API_URL', plugin_dir_url( __FILE__ ) );
define( 'SAUCAL_API_PATH', dirname( __FILE__ ) . '/' );
define( 'SAUCAL_API_INC', SAUCAL_API_PATH . 'includes/' );

// Include files.
require_once SAUCAL_API_INC . 'utils.php';
require_once SAUCAL_API_INC . 'my-account-tab.php';
require_once SAUCAL_API_INC . 'class-saucalapi-widget.php';
require_once SAUCAL_API_INC . 'class-saucalpi-controller.php';
require_once SAUCAL_API_INC . 'frontend.php';

// Flush rules on activation.
register_activation_hook(
	__FILE__,
	function() {
		\SauCalAPI\MyAccountTab\add_endpoint();
		flush_rewrite_rules();
	}
);
