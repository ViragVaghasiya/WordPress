<?php
/**
 * Dsignfly Archive Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Archive Widget Class
 */
class Dsignfly_Archive_Widget extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_archive_widget',
			__( 'Dsignfly Archives Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for popular posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Archive Widget Content
	 *
	 * @param array $args widget arguments.
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo wp_kses( $args['before_widget'], POST_ALLOWED_HTML_TAGS );
		echo '<div class="widget dsignfly-sidebar-widget">';

		if ( ! empty( $title ) ) {
			echo wp_kses(
				$args['before_title'] .
				'<h3 class="dsignfly-subtitle dsign-cursor-default font-regular">' . $title . '</h3><hr>' .
				$args['after_title'],
				POST_ALLOWED_HTML_TAGS
			);
		}

		if ( ! empty( $instance['arc_type'] ) ) {
			$arc_args = array(
				'type'      => $instance['arc_type'],
				'post_type' => 'dsign_portfolio',
				'format'    => 'li',
				'before'    => '<h4 class="font-semi-bold dsignfly-archive-widget-item"> &#x276F; ',
				'after'     => '</h4>',
			);

			echo '<div class="dsignfly-archive-widget-content">' .
				wp_get_archives( $arc_args ) .
			'</div>';
		}
		echo '</div>';
		echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
	}

	/**
	 * Dsignfly Archive Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default values.
		$title    = __( 'Archives', 'dsignfly-theme' );
		$arc_type = 'monthly';

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}

		if ( isset( $instance['arc_type'] ) ) {
			$arc_type = $instance['arc_type'];
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'dsignfly-theme' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" 
				value="<?php echo esc_attr( $title ); ?>"/>

			<label for="<?php echo esc_attr( $this->get_field_id( 'arc_type' ) ); ?>">
				<?php esc_html_e( 'Archive Timeline:', 'dsignfly-theme' ); ?>
			</label>
			<select class="widefat" name="<?php echo esc_attr( $this->get_field_name( 'arc_type' ) ); ?>"
				id="<?php echo esc_attr( $this->get_field_id( 'arc_type' ) ); ?>">
				<option <?php selected( $arc_type, 'daily' ); ?> value="<?php echo esc_attr( 'daily' ); ?>">
					<?php esc_html_e( 'Daily', 'dsignfly-theme' ); ?>
				</option>
				<option <?php selected( $arc_type, 'monthly' ); ?> value="<?php echo esc_attr( 'monthly' ); ?>">
					<?php esc_html_e( 'Monthly', 'dsignfly-theme' ); ?>
				</option>
				<option <?php selected( $arc_type, 'yearly' ); ?> value="<?php echo esc_attr( 'yearly' ); ?>">
					<?php esc_html_e( 'Yearly', 'dsignfly-theme' ); ?>
				</option>
			</select>
		</p>
		<?php
	}

	/**
	 * Dsingfly Archive Widget Instance Update
	 *
	 * @param array $new_instance instance variables array.
	 * @param array $old_instance instance variables array.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = array();
		$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['arc_type'] = ( ! empty( $new_instance['arc_type'] ) ) ? wp_strip_all_tags( $new_instance['arc_type'] ) : '';
		return $instance;
	}
}
