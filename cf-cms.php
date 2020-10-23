<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/raosuresh94/
 * @since             1.0.0
 * @package           Cf_Cms
 *
 * @wordpress-plugin
 * Plugin Name:       Contact Form CMS
 * Plugin URI:        https://github.com/raosuresh94/cf-cms
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Suresh
 * Author URI:        https://github.com/raosuresh94/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cf-cms
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
define( 'CF_CMS_VERSION', '1.0.0' );

define('TABLE_NAME', 'cf_cms');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cf-cms-activator.php
 */
function activate_cf_cms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf-cms-activator.php';
	Cf_Cms_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cf-cms-deactivator.php
 */
function deactivate_cf_cms() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cf-cms-deactivator.php';
	Cf_Cms_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cf_cms' );
register_deactivation_hook( __FILE__, 'deactivate_cf_cms' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cf-cms.php';
require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
require plugin_dir_path( __FILE__ ) . 'admin/class-cf-cms-data.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cf_cms() {

	$plugin = new Cf_Cms();
	$plugin->run();

}
run_cf_cms();
