<?php
/**
 * Dsignfly Recent Posts Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Recent Posts Widget
 */
class Dsignfly_Recent_Posts_Widget extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_recent_posts_widget',
			__( 'Dsignfly recent Posts Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for recent posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Recent Posts Widget Content
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
		$dsignfly_recent_posts = wp_get_recent_posts(
			array(
				'numberposts' => 5,
				'post_status' => 'publish',
				'post_type'   => 'dsign_portfolio',
			)
		);

		if ( ! empty( $dsignfly_recent_posts ) ) {

			echo '<div id="dsignfly-recent-posts-sidebar-widget-content">';
			foreach ( $dsignfly_recent_posts as $posts ) {
				$recent_post_id = $posts['ID'];
				?>
				<div class="dsignfly-recent-posts-item" onclick="location.href='<?php echo esc_url( get_permalink( $recent_post_id ) ); ?>'">
					<?php
					if ( has_post_thumbnail( $recent_post_id ) ) {
						echo get_the_post_thumbnail(
							$recent_post_id,
							'post-thumbnail',
							array( 'class' => 'dsignfly-recent-posts-mini-image dsign-cursor-pointer' )
						);
					} else {
						echo '<img class="dsignfly-recent-posts-mini-image dsign-cursor-pointer"
							src="' . esc_url( dsignfly_default_img_src() ) . '" alt="">';
					}
					?>
					<div class="dsignfly-recent-posts-body font-regular">
						<p class="dsignfly-recent-post-title dsign-cursor-pointer"> <?php echo esc_html( get_the_title( $recent_post_id ) ); ?> </p>
						<div class="dsignfly-recent-posts-body-author">
							<?php esc_html_e( 'by', 'dsignfly-theme' ); ?>
							<a href="<?php echo esc_url( get_author_posts_url( $posts['post_author'] ) ); ?>"
								id="dsignfly-author-link" class="dsignfly-orange-link">
								<?php echo esc_html( get_the_author_meta( 'display_name', $posts['post_author'] ) ); ?>
							</a>
							<?php echo esc_html_e( 'on ', 'dsignfly-theme' ) . get_the_date( 'j F, Y', $recent_post_id ); ?> 
						</div>
					</div>
				</div>
				<?php
			}
			echo '</div>';
		} else {
			echo '<h4 class="font-regular not-found">' . esc_html_e( 'No post found...', 'dsignfly-theme' ) . '</h4>';
		}
		echo '</div>';
		echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
	}

	/**
	 * Dsignfly Recent Posts Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default value.
		$title = __( 'Recent Posts', 'dsignfly-theme' );

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
	 * Dsignfly Recent Posts Widget Instance Update
	 *
	 * @param array $new_instance new instance variables array.
	 * @param array $old_instance old instance variables array.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		return $instance;
	}
}
