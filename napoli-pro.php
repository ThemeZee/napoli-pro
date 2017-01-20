<?php
/*
Plugin Name: Napoli Pro
Plugin URI: http://themezee.com/addons/napoli-pro/
Description: Adds additional features like custom colors, google fonts, widget areas and footer copyright to the Napoli theme.
Author: ThemeZee
Author URI: https://themezee.com/
Version: 1.0
Text Domain: napoli-pro
Domain Path: /languages/
License: GPL v3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Napoli Pro
Copyright(C) 2017, ThemeZee.com - support@themezee.com

*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Main Napoli_Pro Class
 *
 * @package Napoli Pro
 */
class Napoli_Pro {

	/**
	 * Call all Functions to setup the Plugin
	 *
	 * @uses Napoli_Pro::constants() Setup the constants needed
	 * @uses Napoli_Pro::includes() Include the required files
	 * @uses Napoli_Pro::setup_actions() Setup the hooks and actions
	 * @return void
	 */
	static function setup() {

		// Setup Constants.
		self::constants();

		// Setup Translation.
		add_action( 'plugins_loaded', array( __CLASS__, 'translation' ) );

		// Include Files.
		self::includes();

		// Setup Action Hooks.
		self::setup_actions();

	}

	/**
	 * Setup plugin constants
	 *
	 * @return void
	 */
	static function constants() {

		// Define Plugin Name.
		define( 'NAPOLI_PRO_NAME', 'Napoli Pro' );

		// Define Version Number.
		define( 'NAPOLI_PRO_VERSION', '1.0' );

		// Define Plugin Name.
		define( 'NAPOLI_PRO_PRODUCT_ID', 96583 );

		// Define Update API URL.
		define( 'NAPOLI_PRO_STORE_API_URL', 'https://themezee.com' );

		// Plugin Folder Path.
		define( 'NAPOLI_PRO_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

		// Plugin Folder URL.
		define( 'NAPOLI_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

		// Plugin Root File.
		define( 'NAPOLI_PRO_PLUGIN_FILE', __FILE__ );

	}

	/**
	 * Load Translation File
	 *
	 * @return void
	 */
	static function translation() {

		load_plugin_textdomain( 'napoli-pro', false, dirname( plugin_basename( NAPOLI_PRO_PLUGIN_FILE ) ) . '/languages/' );

	}

	/**
	 * Include required files
	 *
	 * @return void
	 */
	static function includes() {

		// Include Admin Classes.
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/admin/class-plugin-updater.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/admin/class-settings.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/admin/class-settings-page.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/admin/class-admin-notices.php';

		// Include Customizer Classes.
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/customizer/class-customizer.php';

		// Include Pro Features.
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/modules/class-custom-colors.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/modules/class-custom-fonts.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/modules/class-header-menu.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/modules/class-footer-line.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/modules/class-footer-widgets.php';

		// Include Magazine Widgets.
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/widgets/widget-magazine-columns.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/widgets/widget-magazine-horizontal-box.php';
		require_once NAPOLI_PRO_PLUGIN_DIR . '/includes/widgets/widget-magazine-vertical-box.php';

	}

	/**
	 * Setup Action Hooks
	 *
	 * @see https://codex.wordpress.org/Function_Reference/add_action WordPress Codex
	 * @return void
	 */
	static function setup_actions() {

		// Enqueue Frontend Widget Styles.
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueue_styles' ), 11 );

		// Register additional Magazine Post Widgets.
		add_action( 'widgets_init', array( __CLASS__, 'register_widgets' ) );

		// Add Settings link to Plugin actions.
		add_filter( 'plugin_action_links_' . plugin_basename( NAPOLI_PRO_PLUGIN_FILE ), array( __CLASS__, 'plugin_action_links' ) );

		// Add automatic plugin updater from ThemeZee Store API.
		add_action( 'admin_init', array( __CLASS__, 'plugin_updater' ), 0 );

	}

	/**
	 * Enqueue Styles
	 *
	 * @return void
	 */
	static function enqueue_styles() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		// Enqueue RTL or default Plugin Stylesheet.
		if ( is_rtl() ) {
			wp_enqueue_style( 'napoli-pro', NAPOLI_PRO_PLUGIN_URL . 'assets/css/napoli-pro-rtl.css', array(), NAPOLI_PRO_VERSION );
		} else {
			wp_enqueue_style( 'napoli-pro', NAPOLI_PRO_PLUGIN_URL . 'assets/css/napoli-pro.css', array(), NAPOLI_PRO_VERSION );
		}

		// Get Custom CSS.
		$custom_css = apply_filters( 'napoli_pro_custom_css_stylesheet', '' );

		// Sanitize Custom CSS.
		$custom_css = wp_kses( $custom_css, array( '\'', '\"' ) );
		$custom_css = str_replace( '&gt;', '>', $custom_css );
		$custom_css = preg_replace( '/\n/', '', $custom_css );
		$custom_css = preg_replace( '/\t/', '', $custom_css );

		// Add Custom CSS.
		wp_add_inline_style( 'napoli-pro', $custom_css );

	}

	/**
	 * Register Magazine Widgets
	 *
	 * @return void
	 */
	static function register_widgets() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		register_widget( 'Napoli_Pro_Magazine_Columns_Widget' );
		register_widget( 'Napoli_Pro_Magazine_Horizontal_Box_Widget' );
		register_widget( 'Napoli_Pro_Magazine_Vertical_Box_Widget' );

	}

	/**
	 * Add Settings link to the plugin actions
	 *
	 * @param array $actions Plugin action links.
	 * @return array $actions Plugin action links
	 */
	static function plugin_action_links( $actions ) {

		$settings_link = array( 'settings' => sprintf( '<a href="%s">%s</a>', admin_url( 'themes.php?page=napoli-pro' ), __( 'Settings', 'napoli-pro' ) ) );

		return array_merge( $settings_link, $actions );
	}

	/**
	 * Load Template Files from the current theme or child theme
	 *
	 * @param string $template Template Name.
	 */
	static function load_theme_template( $slug, $name = null ) {

		// Setup Template.
		if ( isset( $name ) ) {
			$template = $slug . '-' . $name . '.php';
		} else {
			$template = $slug . '.php';
		}

		$located = false;

		// Check child theme for template first, then parent theme.
		if ( file_exists( trailingslashit( get_stylesheet_directory() ) . $template ) ) {

			$located = trailingslashit( get_stylesheet_directory() ) . $template;

		} elseif ( file_exists( trailingslashit( get_template_directory() ) . $template ) ) {

			$located = trailingslashit( get_template_directory() ) . $template;

		}

		// Load Theme Template.
		if ( ! empty( $located ) ) {
			load_template( $located, false );
		}
	}

	/**
	 * Plugin Updater
	 *
	 * @return void
	 */
	static function plugin_updater() {

		if ( ! is_admin() ) :
			return;
		endif;

		$options = Napoli_Pro_Settings::instance();

		if ( $options->get( 'license_key' ) <> '' ) :

			$license_key = trim( $options->get( 'license_key' ) );

			// Setup the updater.
			$napoli_pro_updater = new Napoli_Pro_Plugin_Updater( NAPOLI_PRO_STORE_API_URL, __FILE__, array(
					'version' 	=> NAPOLI_PRO_VERSION,
					'license' 	=> $license_key,
					'item_name' => NAPOLI_PRO_NAME,
					'item_id'   => NAPOLI_PRO_PRODUCT_ID,
					'author' 	=> 'ThemeZee',
				)
			);

		endif;

	}
}

// Run Plugin.
Napoli_Pro::setup();
