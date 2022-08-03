<?php
/**
 * Dsignfly Twitter Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Twitter Widget
 */
class Dsignfly_Twitter extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_tweet',
			__( 'Dsignfly Twitter Posts Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for related posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Twitter Widget Content
	 *
	 * @param array $args widget arguments.
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function widget( $args, $instance ) {

		$title = apply_filters( 'widget_title', $instance['title'] );

		echo wp_kses( $args['before_widget'], POST_ALLOWED_HTML_TAGS );
		echo '<div class="widget dsignfly-sidebar-widget">';

		if ( ! empty( $title ) && ! empty( $instance['twitter_url'] ) ) {
			?>
			<div class="twitter-widgte-title-bar "> 
				<div class="tweeter-widget-title">
					<?php echo wp_kses( $args['before_title'], POST_ALLOWED_HTML_TAGS ); ?>
					<h3 class="dsignfly-subtitle dsign-cursor-default font-regular"> <?php echo esc_html( $title ); ?> </h3>
				</div>
				<a href="'<?php echo esc_url( $instance['twitter_url'] . '?ref_src=twsrc%5Etfw' ); ?>'"
					class="twitter-follow-button dsign-cursor-pointer" data-show-screen-name="false" data-show-count="false">
					<?php esc_html_e( 'Follow', 'dsignfly-theme' ); ?>
				</a>
			</div>
			<hr>
			<?php
		}

		if ( isset( $instance['twitter_url'] ) ) {
			if ( ! empty( $instance['twitter_url'] ) ) {
				?>
				<div class="twitter-latest-post-widget">
					<a class="twitter-timeline twitter-latest-post-widget" 
						data-tweet-limit="1"
						show-replies = "false"
						data-chrome="nofooter noborders transparent noheader"
						href="'<?php echo esc_url( $instance['twitter_url'] . '?ref_src=twsrc%5Etfw' ); ?>'">
					</a>
				</div>
				<?php
				wp_register_script(
					'twitter_widget_js',
					esc_url( 'https://platform.twitter.com/widgets.js' ),
					array( 'jquery' ),
					1.0,
					true
				);
				wp_enqueue_script( 'twitter_widget_js' );
			}
		}
		echo '</div>';
		echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
	}

	/**
	 * Dsignfly Twitter Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default values.
		$title = __( 'Latest Tweet', 'dsignfly-theme' );
		$url   = 'https://twitter.com/automattic';

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}

		if ( isset( $instance['twitter_url'] ) ) {
			if ( ! empty( $instance['twitter_url'] ) ) {
				$url = $instance['twitter_url'];
			}
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'dsignfly-theme' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" 
				value="<?php echo esc_attr( $title ); ?>"/>

			<label for="<?php echo esc_attr( $this->get_field_id( 'twitter_url' ) ); ?>">
				<?php esc_html_e( 'Twitter Handle URL:', 'dsignfly-theme' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter_url' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'twitter_url' ) ); ?>" type="url" 
				value="<?php echo esc_url( $url ); ?>"/>
		</p>
		<?php
	}

	/**
	 * Dsignfly Twitter Widget Instance Update
	 *
	 * @param array $new_instance new instance variables array.
	 * @param array $old_instance old instance variables array.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = array();
		$instance['title']       = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['twitter_url'] = ( ! empty( $new_instance['twitter_url'] ) ) ? wp_strip_all_tags( $new_instance['twitter_url'] ) : '';
		return $instance;
	}
}

