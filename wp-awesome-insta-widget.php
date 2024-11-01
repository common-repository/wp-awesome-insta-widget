<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://jeweltheme.com
 * @since             1.0.0
 * @package           WP_Awesome_Insta_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       WP Awesome Insta Widget
 * Plugin URI:        https://jeweltheme.com/product/wp-awesome-insta-widget/
 * Description:       WordPress Instagram Widget
 * Version:           1.1.2
 * Author:            Liton Arefin
 * Author URI: 		  https://wordpress.org/plugins/ultimate-blocks-for-gutenberg/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-awesome-insta-widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once dirname( __FILE__ ) . '/includes/easy-blocks.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-awesome-insta-widget-activator.php
 */
function activate_WP_Awesome_Insta_Widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-awesome-insta-widget-activator.php';
	WP_Awesome_Insta_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-awesome-insta-widget-deactivator.php
 */
function deactivate_WP_Awesome_Insta_Widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-awesome-insta-widget-deactivator.php';
	WP_Awesome_Insta_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_WP_Awesome_Insta_Widget' );
register_deactivation_hook( __FILE__, 'deactivate_WP_Awesome_Insta_Widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-awesome-insta-widget.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-awesome-insta-widgets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_WP_Awesome_Insta_Widget() {

	$plugin = new WP_Awesome_Insta_Widget();
	$plugin->run();

}
run_WP_Awesome_Insta_Widget();
