<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.netpyx.net/
 * @since             1.0.0
 * @package           Event_calender_extension
 *
 * @wordpress-plugin
 * Plugin Name:       Event Calender Extension
 * Plugin URI:        Event Calender Extension
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Event Calender Extension
 * Author URI:        http://www.netpyx.net/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       event_calender_extension
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-event_calender_extension-activator.php
 */
function activate_event_calender_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event_calender_extension-activator.php';
	Event_calender_extension_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-event_calender_extension-deactivator.php
 */
function deactivate_event_calender_extension() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-event_calender_extension-deactivator.php';
	Event_calender_extension_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_event_calender_extension' );
register_deactivation_hook( __FILE__, 'deactivate_event_calender_extension' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-event_calender_extension.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_event_calender_extension() {

	$plugin = new Event_calender_extension();
	$plugin->run();

}
run_event_calender_extension();
