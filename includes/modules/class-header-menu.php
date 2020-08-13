<?php
/**
 * Header Menu
 *
 * Registers header menu and hooks into the Napoli theme to display it
 *
 * @package Napoli Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Header Menu Class
 */
class Napoli_Pro_Header_Menu {

	/**
	 * Footer Widgets Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		// Display Header Bar.
		add_action( 'napoli_header_menu', array( __CLASS__, 'display_header_menu' ) );

	}

	/**
	 * Displays header navigation and social menu on header bar
	 *
	 * @return void
	 */
	static function display_header_menu() {

		// Check if there is a top navigation menu.
		if ( has_nav_menu( 'secondary' ) ) :
			?>

			<div class="secondary-navigation">

				<nav class="header-navigation container" role="navigation" aria-label="<?php esc_attr_e( 'Secondary Menu', 'napoli-pro' ); ?>">

					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'secondary',
							'menu_id'        => 'secondary-menu',
							'container'      => false,
						)
					);
					?>

				</nav>

			</div><!-- .secondary-navigation -->

			<?php
		endif;
	}

	/**
	 * Register navigation menus
	 *
	 * @return void
	 */
	static function register_nav_menus() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'secondary' => esc_html__( 'Header Bottom', 'napoli-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'Napoli_Pro_Header_Menu', 'setup' ) );

// Register navigation menus in backend.
add_action( 'after_setup_theme', array( 'Napoli_Pro_Header_Menu', 'register_nav_menus' ), 20 );
