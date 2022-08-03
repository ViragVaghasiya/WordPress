<?php
/**
 * Dsignfly Facebook Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Facebook Widget
 */
class Dsignfly_Facebook extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_facebook',
			__( 'Dsignfly Facebook Page Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for related posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Facebook Widget Content
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

		if ( isset( $instance['fb_url'] ) ) {
			if ( ! empty( $instance['fb_url'] ) ) {
				?>
				<div id="fb-root"></div>
				<script async defer crossorigin="anonymous"
					src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v14.0" nonce="ySurA6Vs">
				</script>
				<div class="fb-page"
					data-href="<?php echo esc_url( $instance['fb_url'] ); ?>" 
					data-width="340"
					data-hide-cover="false"
					data-show-facepile="true">
				</div>
				<?php
			}
		}
		echo '</div>';
		echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
	}

	/**
	 * Dsignfly Facebook Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default values.
		$title = '';
		$url   = 'https://www.facebook.com/AutomatticInc/';

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}

		if ( isset( $instance['fb_url'] ) ) {
			$url = $instance['fb_url'];
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'dsignfly-theme' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" 
				value="<?php echo esc_attr( $title ); ?>"/>

			<label for="<?php echo esc_attr( $this->get_field_id( 'fb_url' ) ); ?>">
				<?php esc_html_e( 'Facebook Page URL:', 'dsignfly-theme' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'fb_url' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'fb_url' ) ); ?>" type="url" 
				value="<?php echo esc_url( $url ); ?>"/>
		</p>
		<?php
	}

	/**
	 * Dsignfly Facebook Widget Instance Update
	 *
	 * @param array $new_instance instance variables array.
	 * @param array $old_instance instance variables array.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance           = array();
		$instance['title']  = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['fb_url'] = ( ! empty( $new_instance['fb_url'] ) ) ? wp_strip_all_tags( $new_instance['fb_url'] ) : '';
		return $instance;
	}
}
