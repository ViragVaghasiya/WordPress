<?php
/**
 * Dsignfly Popular Posts Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Popular Posts Widget
 */
class Dsignfly_Popular_Posts_Widget extends Wp_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_popular_posts_widget',
			__( 'Dsignfly popular Posts Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for popular posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Popular Posts Widget Content
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

		$dsignfly_popular_posts_widget_data = get_posts(
			array(
				'post_type'   => 'dsign_portfolio',
				'meta_key'    => 'dsignfly_post_views_count', // phpcs:ignore
				'orderby'     => 'meta_value_num',
				'post_status' => 'publish',
				'numberposts' => 5,
			)
		);

		if ( ! empty( $dsignfly_popular_posts_widget_data ) ) {
			echo '<div id="dsignfly-popular-posts-sidebar-widget-content">';
			foreach ( $dsignfly_popular_posts_widget_data as $popular_post ) {
				$popular_post_id = $popular_post->ID;
				?>
				<div class="dsignfly-popular-posts-item" onclick="location.href='<?php echo esc_url( get_permalink( $popular_post_id ) ); ?>'" >
					<?php
					if ( has_post_thumbnail( $popular_post_id ) ) {
						echo get_the_post_thumbnail(
							$popular_post_id,
							'post-thumbnail',
							array( 'class' => 'dsignfly-popular-posts-mini-image dsign-cursor-pointer' )
						);
					} else {
						echo '<img class="dsignfly-recent-posts-mini-image dsign-cursor-pointer"
							src="' . esc_url( dsignfly_default_img_src() ) . '" alt="">';
					}
					?>
					<div class="dsignfly-popular-posts-body font-regular">
						<p class="dsignfly-popular-post-title dsign-cursor-pointer"> <?php echo esc_html( get_the_title( $popular_post_id ) ); ?> </p>
						<div class="dsignfly-popular-posts-body-author">
							<?php esc_html_e( 'by', 'dsignfly-theme' ); ?>
							<a href="<?php echo esc_url( get_author_posts_url( $popular_post->post_author ) ); ?>"
								id="dsignfly-author-link" class="dsignfly-orange-link">
								<?php echo esc_html( get_the_author_meta( 'display_name', $popular_post->post_author ) ); ?>
							</a>
							<?php echo esc_html__( 'on ', 'dsignfly-theme' ) . get_the_date( 'j F, Y', $popular_post_id ); ?>
						</div>
					</div>
				</div>
				<?php
			}
			echo '</div>';
		} else {
			echo '<h4 class="font-regular not-found">' . esc_html__( 'No post found...', 'dsignfly-theme' ) . '</h4>';
		}
		echo '</div>';
		echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
	}

	/**
	 * Dsignfly Popular Posts Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default value.
		$title = __( 'Popular Posts', 'dsignfly-theme' );

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>">
				<?php esc_html_e( 'Title:', 'dsignfly-theme' ); ?>
			</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" 
				name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" 
				value="<?php echo esc_attr( $title ); ?>"/>
		</p>
		<?php
	}

	/**
	 * Dsignfly Popular Posts Widget Instance Update
	 *
	 * @param array $new_instance instance variables array.
	 * @param array $old_instance instance variables array.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}
