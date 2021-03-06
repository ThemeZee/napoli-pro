<?php
/**
 * Napoli Pro Settings Page Class
 *
 * Adds a new tab on the themezee plugins page and displays the settings page.
 *
 * @package Napoli Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }


/**
 * Settings Page Class
 */
class Napoli_Pro_Settings_Page {

	/**
	 * Setup the Settings Page class
	 *
	 * @return void
	 */
	static function setup() {

		// Add settings page to appearance menu.
		add_action( 'admin_menu', array( __CLASS__, 'add_settings_page' ), 12 );

		// Enqueue Settings CSS.
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'settings_page_css' ) );
	}

	/**
	 * Add Settings Page to Admin menu
	 *
	 * @return void
	 */
	static function add_settings_page() {

		// Return early if Napoli Theme is not active.
		if ( ! current_theme_supports( 'napoli-pro' ) ) {
			return;
		}

		add_theme_page(
			esc_html__( 'Pro Version', 'napoli-pro' ),
			esc_html__( 'Pro Version', 'napoli-pro' ),
			'edit_theme_options',
			'napoli-pro',
			array( __CLASS__, 'display_settings_page' )
		);

	}

	/**
	 * Display settings page
	 *
	 * @return void
	 */
	static function display_settings_page() {

		// Get Theme Details from style.css.
		$theme = wp_get_theme();

		ob_start();
		?>

		<div class="wrap pro-version-wrap">

			<h1><?php echo NAPOLI_PRO_NAME; ?> <?php echo NAPOLI_PRO_VERSION; ?></h1>

			<div id="napoli-pro-settings" class="napoli-pro-settings-wrap">

				<form class="napoli-pro-settings-form" method="post" action="options.php">
					<?php
						settings_fields( 'napoli_pro_settings' );
						do_settings_sections( 'napoli_pro_settings' );
					?>
				</form>

				<p><?php printf( __( 'You can find your license keys and manage your active sites on <a href="%s" target="_blank">themezee.com</a>.', 'napoli-pro' ), __( 'https://themezee.com/license-keys/', 'napoli-pro' ) . '?utm_source=plugin-settings&utm_medium=textlink&utm_campaign=napoli-pro&utm_content=license-keys' ); ?></p>

			</div>

		</div>

		<?php
		echo ob_get_clean();
	}

	/**
	 * Enqueues CSS for Settings page
	 *
	 * @param String $hook Slug of settings page.
	 * @return void
	 */
	static function settings_page_css( $hook ) {

		// Load styles and scripts only on theme info page.
		if ( 'appearance_page_napoli-pro' != $hook ) {
			return;
		}

		// Embed theme info css style.
		wp_enqueue_style( 'napoli-pro-settings-css', plugins_url( '/assets/css/settings.css', dirname( dirname( __FILE__ ) ) ), array(), NAPOLI_PRO_VERSION );

	}
}

// Run Napoli Pro Settings Page Class.
Napoli_Pro_Settings_Page::setup();
