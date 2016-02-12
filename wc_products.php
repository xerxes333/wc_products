<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://triple3studios.com
 * @since             1.0.0
 * @package           Wc_products
 *
 * @wordpress-plugin
 * Plugin Name:       WC Products
 * Plugin URI:        http://thewirecutter.com/
 * Description:       This plugin connects to the Diffbot api and retrieves a product from a user supplied URL
 * Version:           1.0.0
 * Author:            Jeremy
 * Author URI:        http://triple3studios.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc_products
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc_products-activator.php
 */
function activate_wc_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_products-activator.php';
	Wc_products_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc_products-deactivator.php
 */
function deactivate_wc_products() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc_products-deactivator.php';
	Wc_products_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_products' );
register_deactivation_hook( __FILE__, 'deactivate_wc_products' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wc_products.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_products() {

	$plugin = new Wc_products();
	$plugin->run();

}
run_wc_products();
