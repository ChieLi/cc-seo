<?php
/**
 * Plugin Name: cc-seo
 * Plugin URI: https://blog.chiecode.com
 * Description: basic seo tool
 * Version: 0.0.1
 * Author: Chie
 * License: GPLv3
 * License URL: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package cc-seo
 * @authors chie (liqianhui0522@163.com)
 * @date    2021-12-13 17:05:01
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update 4it as you release new versions.
 */
define( 'CC_SEO_VERSION', '0.0.1' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cc-seo-activator.php';
    CC_SEO_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-cc-seo-deactivator.php';
    CC_SEO_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-cc-seo.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

    $plugin = new CC_SEO();
    $plugin->run();

}
run_plugin_name();