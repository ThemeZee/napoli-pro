<?php
/**
 * Magazine Horizontal Box Widget
 *
 * Display the latest posts from a selected category in a horizontal box layout.
 * Intented to be used in the Magazine Homepage widget area to built a magazine layouted page.
 *
 * @package Napoli Pro
 */

/**
 * Magazine Widget Class
 */
class Napoli_Pro_Magazine_Horizontal_Box_Widget extends WP_Widget {

	/**
	 * Widget Constructor
	 */
	function __construct() {

		// Setup Widget.
		parent::__construct(
			'napoli-magazine-horizontal-box', // ID.
			esc_html__( 'Magazine (Horizontal Box)', 'napoli-pro' ), // Name.
			array(
				'classname' => 'napoli-magazine-horizontal-box-widget',
				'description' => esc_html__( 'Displays your posts from a selected category in a horizontal box layout. Please use this widget ONLY in the Magazine Homepage widget area.', 'napoli-pro' ),
				'customize_selective_refresh' => true,
			) // Args.
		);
	}

	/**
	 * Set default settings of the widget
	 */
	private function default_settings() {

		$defaults = array(
			'title'				=> '',
			'category'			=> 0,
		);

		return $defaults;
	}

	/**
	 * Main Function to display the widget
	 *
	 * @uses this->render()
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $instance / Settings for this widget instance.
	 */
	function widget( $args, $instance ) {

		// Show message to admins if Theme is not updated.
		if ( ! function_exists( 'napoli_get_magazine_post_ids' ) ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				echo '<p>INFO: Magazine Widget is missing theme functions and can not be displayed. Please update the theme to the latest version. This message is only shown to admins.</p>';
			}
			return;
		}

		// Start Output Buffering.
		ob_start();

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );

		// Output.
		echo $args['before_widget'];
		?>
		<div class="widget-magazine-horizontal-box widget-magazine-posts clearfix">

			<?php // Display Title.
			$this->widget_title( $args, $settings ); ?>

			<div class="widget-magazine-posts-content">

				<?php $this->render( $settings ); ?>

			</div>

		</div>

		<?php
		echo $args['after_widget'];

		// End Output Buffering.
		ob_end_flush();
	}

	/**
	 * Renders the Widget Content
	 *
	 * @used-by this->widget()
	 *
	 * @param array $settings / Settings for this widget instance.
	 */
	function render( $settings ) {

		// Get cached post ids.
		$post_ids = napoli_get_magazine_post_ids( $this->id, $settings['category'], 5 );

		// Fetch posts from database.
		$query_arguments = array(
			'post__in'       => $post_ids,
			'posts_per_page' => 5,
			'no_found_rows'  => true,
		);
		$posts_query = new WP_Query( $query_arguments );

		// Check if there are posts.
		if ( $posts_query->have_posts() ) :

			// Display Posts.
			while ( $posts_query->have_posts() ) : $posts_query->the_post();

				// Display first two posts differently.
				if ( $posts_query->current_post < 2 ) :

					if ( 0 === $posts_query->current_post ) :
						echo '<div class="magazine-grid magazine-grid-two-columns clearfix">';
					endif;

					echo '<div class="post-column">';
					get_template_part( 'template-parts/widgets/magazine-large-post', 'horizontal-box' );
					echo '</div>';

					if ( 1 === $posts_query->current_post ) :
						echo '</div>';
						echo '<div class="magazine-grid magazine-grid-three-columns clearfix">';
					endif;

				else :

					echo '<div class="post-column">';
					get_template_part( 'template-parts/widgets/magazine-medium-post', 'horizontal-box' );
					echo '</div>';

				endif;

			endwhile;

			echo '</div><!-- end .magazine-three-columns -->';

		endif;

		// Reset Postdata.
		wp_reset_postdata();
	}

	/**
	 * Displays Widget Title
	 *
	 * @param array $args / Parameters from widget area created with register_sidebar().
	 * @param array $settings / Settings for this widget instance.
	 */
	function widget_title( $args, $settings ) {

		// Add Widget Title Filter.
		$widget_title = apply_filters( 'widget_title', $settings['title'], $settings, $this->id_base );

		if ( ! empty( $widget_title ) ) :

			// Link Widget Title to category archive when possible.
			$widget_title = napoli_magazine_widget_title( $widget_title, $settings['category'] );

			// Display Widget Title.
			echo $args['before_title'] . $widget_title . $args['after_title'];

		endif;
	}

	/**
	 * Update Widget Settings
	 *
	 * @param array $new_instance / New Settings for this widget instance.
	 * @param array $old_instance / Old Settings for this widget instance.
	 * @return array $instance
	 */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['category'] = (int) $new_instance['category'];

		napoli_flush_magazine_post_ids();

		return $instance;
	}

	/**
	 * Displays Widget Settings Form in the Backend
	 *
	 * @param array $instance / Settings for this widget instance.
	 */
	function form( $instance ) {

		// Get Widget Settings.
		$settings = wp_parse_args( $instance, $this->default_settings() );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'napoli-pro' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $settings['title'] ); ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php esc_html_e( 'Category:', 'napoli-pro' ); ?></label><br/>
			<?php // Display Category Select.
				$args = array(
					'show_option_all'    => esc_html__( 'All Categories', 'napoli-pro' ),
					'show_count' 		 => true,
					'hide_empty'		 => false,
					'selected'           => $settings['category'],
					'name'               => $this->get_field_name( 'category' ),
					'id'                 => $this->get_field_id( 'category' ),
				);
				wp_dropdown_categories( $args );
			?>
		</p>

		<?php
	}
}
