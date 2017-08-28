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
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
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

	$plugin = new Bp_Groups_Export_Import();
	$plugin->run();

}
run_bp_groups_export_import();
