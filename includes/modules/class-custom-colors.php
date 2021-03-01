<?php
/**
 * Custom Colors
 *
 * Adds color settings to Customizer and generates color CSS code
 *
 * @package Napoli Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom Colors Class
 */
class Napoli_Pro_Custom_Colors {

	/**
	 * Custom Colors Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		// Add Custom Color CSS code to custom stylesheet output.
		add_filter( 'napoli_pro_custom_css_stylesheet', array( __CLASS__, 'custom_colors_css' ) );

		// Add Custom Color Settings.
		add_action( 'customize_register', array( __CLASS__, 'color_settings' ) );

	}

	/**
	 * Adds Color CSS styles in the head area to override default colors
	 *
	 * @param String $custom_css Custom Styling CSS.
	 * @return string CSS code
	 */
	static function custom_colors_css( $custom_css ) {

		// Get Theme Options from Database.
		$theme_options = Napoli_Pro_Customizer::get_theme_options();

		// Get Default Fonts from settings.
		$default_options = Napoli_Pro_Customizer::get_default_options();

		// Color Variables.
		$color_variables = '';

		// Set Header Color.
		if ( $theme_options['header_color'] != $default_options['header_color'] ) {
			$color_variables .= '--page-background-color: ' . $theme_options['page_bg_color'] . ';';

			$custom_css .= '
				.site-header {
					background: ' . $theme_options['header_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_light( $theme_options['header_color'] ) ) {
				$custom_css .= '
					.site-title,
					.site-title a:link,
					.site-title a:visited,
					.main-navigation ul a,
					.main-navigation ul a:link,
					.main-navigation ul a:visited,
					.header-social-icons .social-icons-menu li a,
					.header-search .header-search-icon {
						color: #111111;
					}

					.site-title a:hover,
					.site-title a:active,
					.main-navigation ul a:hover,
					.main-navigation ul a:active,
					.header-social-icons .social-icons-menu li a:active,
					.header-social-icons .social-icons-menu li a:hover,
					.header-search .header-search-icon:hover {
						color: rgba(0,0,0,0.5);
					}

					.mobile-menu-toggle .icon,
					.main-navigation .dropdown-toggle .icon,
					.main-navigation ul .menu-item-has-children > a > .icon {
					    fill: #111111;
					}

					.mobile-menu-toggle:hover .icon,
					.mobile-menu-toggle:active .icon,
					.main-navigation .dropdown-toggle:hover .icon,
					.main-navigation .dropdown-toggle:active .icon,
					.main-navigation ul .menu-item-has-children > a:hover > .icon,
					.main-navigation ul .menu-item-has-children > a:active > .icon {
						fill: rgba(0,0,0,0.5);
					}

					.main-navigation ul-wrap,
					.main-navigation ul a {
						border-color: rgba(0,0,0,0.1);
					}
				';
			}
		}

		// Set Navigation Color.
		if ( $theme_options['navigation_color'] != $default_options['navigation_color'] ) {

			$custom_css .= '
				.secondary-navigation {
					background: ' . $theme_options['navigation_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_dark( $theme_options['navigation_color'] ) ) {
				$custom_css .= '
					.header-navigation > ul > li > a,
					.header-navigation > ul > li > a:link,
					.header-navigation > ul > li > a:visited {
						color: #ffffff;
					}

					.header-navigation > ul > li > a:hover,
					.header-navigation > ul > li > a:active {
						color: rgba(255,255,255,0.5);
					}

					.header-navigation > ul > li > .dropdown-toggle .icon,
					.header-navigation > ul > .menu-item-has-children > a > .icon {
					    fill: #ffffff;
					}

					.header-navigation > ul > li > .dropdown-toggle:hover .icon,
					.header-navigation > ul > li > .dropdown-toggle:active .icon,
					.header-navigation > ul > .menu-item-has-children > a:hover > .icon,
					.header-navigation > ul > .menu-item-has-children > a:active > .icon {
						fill:rgba(255,255,255,0.5);
					}

					.header-navigation > ul > li > a {
						border-color: rgba(255,255,255,0.1);
					}
				';
			}
		}

		// Set Title Color.
		if ( $theme_options['title_color'] != $default_options['title_color'] ) {

			$custom_css .= '
				.page-title,
				.entry-title,
				.entry-title a:link,
				.entry-title a:visited {
					color: ' . $theme_options['title_color'] . ';
				}

				.entry-title a:hover,
				.entry-title a:active {
					color: #303030;
				}
			';
		}

		// Set Widget Title Color.
		if ( $theme_options['widget_title_color'] != $default_options['widget_title_color'] ) {

			$custom_css .= '
				.widget-title,
				.page-header .archive-title,
				.comments-header,
				.comment-reply-title,
				.related-posts-title {
					background: ' . $theme_options['widget_title_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_light( $theme_options['widget_title_color'] ) ) {
				$custom_css .= '
					.widget-title,
					.widget-title a:link,
					.widget-title a:visited,
					.page-header .archive-title,
					.comments-header .comments-title,
					.comment-reply-title,
					.comment-reply-title small a:link,
					.comment-reply-title small a:visited,
					.related-posts-title {
						color: #111111;
					}
					.widget-title a:hover,
					.widget-title a:active,
					.comment-reply-title small a:link,
					.comment-reply-title small a:visited {
						color: rgba(0,0,0,0.5);
					}
				';
			}
		}

		// Set Primary Content Color.
		if ( $theme_options['link_color'] != $default_options['link_color'] ) {

			$custom_css .= '
				a,
				a:link,
				a:visited,
				.has-primary-color {
					color: ' . $theme_options['link_color'] . ';
				}

				a:hover,
				a:focus,
				a:active {
					color: #303030;
				}

				blockquote {
					border-color: ' . $theme_options['link_color'] . ';
				}

				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.widget_tag_cloud .tagcloud a,
				.entry-tags .meta-tags a,
				.pagination a:hover,
				.pagination a:active,
				.pagination .current,
				.infinite-scroll #infinite-handle span:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a:hover,
				.tzwb-tabbed-content .tzwb-tabnavi li a:active,
				.tzwb-tabbed-content .tzwb-tabnavi li a.current-tab,
				.tzwb-social-icons .social-icons-menu li a:link,
				.tzwb-social-icons .social-icons-menu li a:visited,
				.scroll-to-top-button,
				.scroll-to-top-button:focus,
				.scroll-to-top-button:active,
				.has-primary-background-color {
					background-color: ' . $theme_options['link_color'] . ';
				}

				.tzwb-social-icons .social-icons-menu li a:hover,
				.tzwb-social-icons .social-icons-menu li a:active {
					background: #303030;
				}
			';
		}

		// Set Footer Color.
		if ( $theme_options['footer_color'] != $default_options['footer_color'] ) {

			$custom_css .= '
				.footer-wrap,
				.footer-widgets-background {
					background: ' . $theme_options['footer_color'] . ';
				}
			';

			// Check if a dark background color was chosen.
			if ( self::is_color_light( $theme_options['footer_color'] ) ) {
				$custom_css .= '
					.footer-widgets-background,
					.footer-widgets .widget,
					.footer-widgets .widget-title {
						border-color: rgba(0,0,0,0.1);
					}
					.site-footer,
					.site-footer .site-info a:link,
					.site-footer .site-info a:visited,
					.footer-navigation-menu a:link,
					.footer-navigation-menu a:visited,
					.footer-widgets .widget,
					.footer-widgets .widget-title,
					.footer-widgets .widget a:link,
					.footer-widgets .widget a:visited {
						color: #111111;
					}
					.site-footer .site-info a:hover,
					.site-footer .site-info a:active,
					.footer-navigation-menu a:hover,
					.footer-navigation-menu a:active,
					.footer-widgets .widget,
					.footer-widgets .widget a:hover,
					.footer-widgets .widget a:active {
						color: rgba(0,0,0,0.5);
					}
				';
			}
		}

		// Set Color Variables.
		if ( '' !== $color_variables ) {
			$custom_css .= ':root {' . $color_variables . '}';
		}

		return $custom_css;
	}

	/**
	 * Adds all color settings in the Customizer
	 *
	 * @param object $wp_customize / Customizer Object.
	 */
	static function color_settings( $wp_customize ) {

		// Add Section for Theme Colors.
		$wp_customize->add_section( 'napoli_pro_section_colors', array(
			'title'    => __( 'Theme Colors', 'napoli-pro' ),
			'priority' => 60,
			'panel'    => 'napoli_options_panel',
		) );

		// Get Default Colors from settings.
		$default_options = Napoli_Pro_Customizer::get_default_options();

		// Add Navigation Primary Color setting.
		$wp_customize->add_setting( 'napoli_theme_options[header_color]', array(
			'default'           => $default_options['header_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'napoli_theme_options[header_color]', array(
				'label'    => _x( 'Header', 'color setting', 'napoli-pro' ),
				'section'  => 'napoli_pro_section_colors',
				'settings' => 'napoli_theme_options[header_color]',
				'priority' => 10,
			)
		) );

		// Add Navigation Color setting.
		$wp_customize->add_setting( 'napoli_theme_options[navigation_color]', array(
			'default'           => $default_options['navigation_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'napoli_theme_options[navigation_color]', array(
				'label'    => _x( 'Navigation', 'color setting', 'napoli-pro' ),
				'section'  => 'napoli_pro_section_colors',
				'settings' => 'napoli_theme_options[navigation_color]',
				'priority' => 20,
			)
		) );

		// Add Content Primary Color setting.
		$wp_customize->add_setting( 'napoli_theme_options[link_color]', array(
			'default'           => $default_options['link_color'],
			'type'              => 'option',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'napoli_theme_options[link_color]', array(
				'label'    => _x( 'Links and Buttons', 'color setting', 'napoli-pro' ),
				'section'  => 'napoli_pro_section_colors',
				'settings' => 'napoli_theme_options[link_color]',
				'priority' => 30,
			)
		) );

		// Add Content Secondary Color setting.
		$wp_customize->add_setting( 'napoli_theme_options[title_color]', array(
			'default'           => $default_options['title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'napoli_theme_options[title_color]', array(
				'label'    => _x( 'Headings', 'color setting', 'napoli-pro' ),
				'section'  => 'napoli_pro_section_colors',
				'settings' => 'napoli_theme_options[title_color]',
				'priority' => 40,
			)
		) );

		// Add Content Secondary Color setting.
		$wp_customize->add_setting( 'napoli_theme_options[widget_title_color]', array(
			'default'           => $default_options['widget_title_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'napoli_theme_options[widget_title_color]', array(
				'label'    => _x( 'Widget Titles', 'color setting', 'napoli-pro' ),
				'section'  => 'napoli_pro_section_colors',
				'settings' => 'napoli_theme_options[widget_title_color]',
				'priority' => 40,
			)
		) );

		// Add Footer Color setting.
		$wp_customize->add_setting( 'napoli_theme_options[footer_color]', array(
			'default'           => $default_options['footer_color'],
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize, 'napoli_theme_options[footer_color]', array(
				'label'    => _x( 'Footer', 'color setting', 'napoli-pro' ),
				'section'  => 'napoli_pro_section_colors',
				'settings' => 'napoli_theme_options[footer_color]',
				'priority' => 50,
			)
		) );
	}

	/**
	 * Returns color brightness.
	 *
	 * @param int Number of brightness.
	 */
	static function get_color_brightness( $hex_color ) {

		// Remove # string.
		$hex_color = str_replace( '#', '', $hex_color );

		// Convert into RGB.
		$r = hexdec( substr( $hex_color, 0, 2 ) );
		$g = hexdec( substr( $hex_color, 2, 2 ) );
		$b = hexdec( substr( $hex_color, 4, 2 ) );

		return ( ( ( $r * 299 ) + ( $g * 587 ) + ( $b * 114 ) ) / 1000 );
	}

	/**
	 * Check if the color is light.
	 *
	 * @param bool True if color is light.
	 */
	static function is_color_light( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) > 130 );
	}

	/**
	 * Check if the color is dark.
	 *
	 * @param bool True if color is dark.
	 */
	static function is_color_dark( $hex_color ) {
		return ( self::get_color_brightness( $hex_color ) <= 130 );
	}
}

// Run Class.
add_action( 'init', array( 'Napoli_Pro_Custom_Colors', 'setup' ) );
