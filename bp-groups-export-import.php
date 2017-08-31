<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wbcomdesigns.com/
 * @since             1.0.0
 * @package           Bp_Groups_Export_Import
 *
 * @wordpress-plugin
 * Plugin Name:       BuddyPress Groups Export & Import
 * Plugin URI:        https://wbcomdesigns.com/
 * Description:       This plugin helps the site administrator to export & import buddypress groups.
 * Version:           1.0.0
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bp-groups-export-import
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'BPGEI_TEXT_DOMAIN' ) ) {
	define( 'BPGEI_TEXT_DOMAIN', 'bp-groups-export-import' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-bp-groups-export-import-activator.php
 */
function activate_bp_groups_export_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bp-groups-export-import-activator.php';
	Bp_Groups_Export_Import_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-bp-groups-export-import-deactivator.php
 */
function deactivate_bp_groups_export_import() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-bp-groups-export-import-deactivator.php';
	Bp_Groups_Export_Import_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_bp_groups_export_import' );
register_deactivation_hook( __FILE__, 'deactivate_bp_groups_export_import' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-bp-groups-export-import.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_bp_groups_export_import() {

	if ( ! defined( 'BPGEI_PLUGIN_URL' ) ) {
		define( 'BPGEI_PLUGIN_URL', plugin_dir_url(__FILE__) );
	}

	if ( ! defined( 'BPGEI_PLUGIN_PATH' ) ) {
		define( 'BPGEI_PLUGIN_PATH', plugin_dir_path(__FILE__) );
	}

	$plugin = new Bp_Groups_Export_Import();
	$plugin->run();

}

/**
 * Check plugin requirement on plugins loaded
 * this plugin requires BuddyPress to be installed and active
 */
add_action( 'plugins_loaded', 'bpgei_plugin_init' );
function bpgei_plugin_init() {
	$bp_active = in_array( 'buddypress/bp-loader.php', get_option( 'active_plugins' ) );
	if ( current_user_can('activate_plugins') && $bp_active !== true ) {
		add_action('admin_notices', 'bpgei_plugin_admin_notice');
	} else {
		$bp_active_components = get_option( 'bp-active-components', true );
		if ( !array_key_exists( 'groups' ,$bp_active_components ) ) {
			add_action('admin_notices', 'bpgei_plugin_require_groups_component_admin_notice');
		} else {
			run_bp_groups_export_import();
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'bpgei_plugin_links' );
		}
	}
}

function bpgei_plugin_admin_notice() {
	$bpgei_plugin = 'BuddyPress Groups Export & Import';
	$bp_plugin = 'BuddyPress';

	echo '<div class="error"><p>'
	. sprintf(__('%1$s is ineffective as it requires %2$s to be installed and active.', BPGEI_TEXT_DOMAIN), '<strong>' . esc_html($bpgei_plugin) . '</strong>', '<strong>' . esc_html($bp_plugin) . '</strong>')
	. '</p></div>';
	if (isset($_GET['activate'])) unset($_GET['activate']);
}

function bpgei_plugin_require_groups_component_admin_notice() {
	$bpgei_plugin = 'BuddyPress Groups Export & Import';
	$bp_component = 'BuddyPress\'s Groups Component';

	echo '<div class="error"><p>'
	. sprintf(__('%1$s is ineffective now as it requires %2$s to be active.', BPGEI_TEXT_DOMAIN), '<strong>' . esc_html($bpgei_plugin) . '</strong>', '<strong>' . esc_html($bp_component) . '</strong>')
	. '</p></div>';
	if (isset($_GET['activate'])) unset($_GET['activate']);
}

function bpgei_plugin_links( $links ) {
	$bpgei_links = array(
		'<a href="'.admin_url('options-general.php?page=bp-groups-export-import').'">'.__( 'Settings', BPGEI_TEXT_DOMAIN ).'</a>',
		'<a href="https://wbcomdesigns.com/contact/" target="_blank">'.__( 'Support', BPGEI_TEXT_DOMAIN ).'</a>'
	);
	return array_merge( $links, $bpgei_links );
}