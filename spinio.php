<?php

/**
 * The plugin bootstrap file.
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @see               https://xfinitysoft.com/
 * @since             1.0.1
 *
 * @wordpress-plugin
 * Plugin Name:       Spin to Win Wheel - Spinio
 * Plugin URI:        https://xfinitysoft.com/products/spinio/
 * Description:       World First Interactive Intent Pop-up which will boost your conversion and user intraction.
 * Version:           1.0.5
 * Author:            xfinitysoft
 * Author URI:        https://xfinitysoft.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Requires at least: 4.0.0
 * WC requires at least: 3.0.0
 * WC tested up to: 6.0
 * Tested up to: 6.2
 * Requires PHP: 5.6
 * Stable tag: 1.0.5
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('spinio', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-spinio-activator.php.
 */
function activate_spinio()
{
    require_once plugin_dir_path(__FILE__).'includes/class-spinio-activator.php';
    spinio_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spinio-deactivator.php.
 */
function deactivate_spinio()
{
    require_once plugin_dir_path(__FILE__).'includes/class-spinio-deactivator.php';
    spinio_Deactivator::deactivate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-spinio-deactivator.php.
 */
function activated_spinio()
{
    exit(wp_redirect(admin_url('admin.php?page=spinio-display')));
}

add_action('activated_plugin', 'activated_spinio', 10, 2);
register_activation_hook(__FILE__, 'activate_spinio');
register_deactivation_hook(__FILE__, 'deactivate_spinio');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__).'includes/class-spinio.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_spinio()
{
    $plugin = new spinio();
    $plugin->run();
}
run_spinio();
