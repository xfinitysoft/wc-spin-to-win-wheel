<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://xfinitysoft.com/
 * @since      1.0.0
 *
 * @package    spinio
 * @subpackage spinio/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    spinio
 * @subpackage spinio/includes
 * @author     xfinitysoft <support@xfinitysoft.com>
 */
class spinio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;
	
	/**
	 * The object of the class subscriber
	 * @since 1.0.0
	 * @access protected
	 * /
	protected $spinio_sub;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'SPINIO_VERSION' ) ) {
			$this->version = SPINIO_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'spinio';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-spinio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-spinio-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-spinio-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-spinio-public.php';
		
		
		$this->loader = new spinio_Loader();
		
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new spinio_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new spinio_Admin( $this->get_plugin_name(), $this->get_version() );
		
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// adding admin menu
		$this->loader->add_action('admin_notices',$plugin_admin,'woo_check');
		$this->loader->add_action('admin_menu',$plugin_admin,'admin_display_page');
		$this->loader->add_action('wp_ajax_slice_wheel_form',$plugin_admin,'slice_wheel_form');
		$this->loader->add_action('wp_ajax_nopriv_get_slices',$plugin_admin,'get_slices');
		//$this->loader->add_action('wp_ajax_get_wheel_json',$plugin_admin,'get_wheel_json');
		//$this->loader->add_action('wp_ajax_nopriv_get_wheel_json',$plugin_admin,'get_wheel_json');
		$this->loader->add_action('wp_ajax_nopriv_spinio_wheel_themes',$plugin_admin,'spnio_wheel_themes');
		$this->loader->add_action('wp_ajax_spinio_style_del',$plugin_admin,'spinio_style_del');
		$this->loader->add_action('wp_ajax_spinio_form_right',$plugin_admin,'spinio_form_right');
		$this->loader->add_action('wp_ajax_spinio_display_save',$plugin_admin,'spinio_display_save');
		$this->loader->add_action('wp_ajax_export_spinio_subscribers',$plugin_admin,'export_spinio_subscribers');
		$this->loader->add_action('admin_post_spinio_form_save_style',$plugin_admin,'spinio_form_save_style');
		$this->loader->add_action('admin_post_spinio_save_settings',$plugin_admin,'spinio_save_settings');
		$this->loader->add_action('wp_ajax_xs_send_mail',$plugin_admin,'xs_send_mail');


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new spinio_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'add_short_codes' );
		$this->loader->add_action('wp_ajax_get_wheel_json',$plugin_public,'get_wheel_json');
		$this->loader->add_action('wp_ajax_nopriv_get_wheel_json',$plugin_public,'get_wheel_json');
		$this->loader->add_action('wp_ajax_nopriv_spinio_set_subscriber',$plugin_public,'spinio_set_subscriber');
		$this->loader->add_action('wp_ajax_spinio_set_subscriber',$plugin_public,'spinio_set_subscriber');
		$this->loader->add_action('wp_head',$plugin_public,'showWheel');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
