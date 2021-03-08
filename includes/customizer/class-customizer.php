<?php
/**
 * Customizer
 *
 * Setup the Customizer and theme options for the Pro plugin
 *
 * @package Napoli Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Class
 */
class Napoli_Pro_Customizer {

	/**
	 * Customizer Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		// Enqueue scripts and styles in the Customizer.
		add_action( 'customize_preview_init', array( __CLASS__, 'customize_preview_js' ) );
		add_action( 'customize_controls_print_styles', array( __CLASS__, 'customize_preview_css' ) );

		// Remove Upgrade section.
		remove_action( 'customize_register', 'napoli_customize_register_upgrade_settings' );
	}

	/**
	 * Get saved user settings from database or plugin defaults
	 *
	 * @return array
	 */
	static function get_theme_options() {

		// Merge Theme Options Array from Database with Default Options Array.
		return wp_parse_args( get_option( 'napoli_theme_options', array() ), self::get_default_options() );
	}


	/**
	 * Returns the default settings of the plugin
	 *
	 * @return array
	 */
	static function get_default_options() {

		$default_options = array(
			'header_bar_text'           => '',
			'logo_spacing'              => 0,
			'header_spacing'            => 20,
			'header_search'             => false,
			'author_bio'                => false,
			'scroll_to_top'             => false,
			'footer_social_icons_text'  => __( 'Stay in Touch', 'napoli-pro' ),
			'footer_text'               => '',
			'credit_link'               => true,
			'primary_color'             => '#ee4455',
			'secondary_color'           => '#d52b3c',
			'tertiary_color'            => '#bb1122',
			'accent_color'              => '#4466ee',
			'highlight_color'           => '#eee644',
			'light_gray_color'          => '#e0e0e0',
			'gray_color'                => '#999999',
			'dark_gray_color'           => '#303030',
			'header_color'              => '#ee4455',
			'navigation_color'          => '#ffffff',
			'link_color'                => '#ee4455',
			'title_color'               => '#ee4455',
			'widget_title_color'        => '#ee4455',
			'footer_color'              => '#ee4455',
			'text_font'                 => 'Open Sans',
			'title_font'                => 'Montserrat',
			'title_is_bold'             => false,
			'title_is_uppercase'        => false,
			'navi_font'                 => 'Montserrat',
			'navi_is_bold'              => false,
			'navi_is_uppercase'         => true,
			'widget_title_font'         => 'Montserrat',
			'widget_title_is_bold'      => false,
			'widget_title_is_uppercase' => true,
		);

		return $default_options;
	}

	/**
	 * Embed JS file to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @return void
	 */
	static function customize_preview_js() {
		wp_enqueue_script( 'napoli-pro-customizer-js', NAPOLI_PRO_PLUGIN_URL . 'assets/js/customize-preview.js', array( 'customize-preview' ), '20210215', true );
	}

	/**
	 * Embed CSS styles for the theme options in the Customizer
	 *
	 * @return void
	 */
	static function customize_preview_css() {
		wp_enqueue_style( 'napoli-pro-customizer-css', NAPOLI_PRO_PLUGIN_URL . 'assets/css/customizer.css', array(), '20210212' );
	}
}

// Run Class.
add_action( 'init', array( 'Napoli_Pro_Customizer', 'setup' ) );
