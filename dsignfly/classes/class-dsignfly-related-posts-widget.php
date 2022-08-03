<?php
/**
 * Dsignfly Related Posts Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Related Posts Widget
 */
class Dsignfly_Related_Posts_Widget extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_related_posts_widget',
			__( 'Dsignfly Related Posts Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for related posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Related Posts Widget Content
	 *
	 * @param array $args widget arguments.
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function widget( $args, $instance ) {

		if ( is_single() || is_admin() ) {

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

			$current_post_obj = get_queried_object();
			$tags_arr         = array();
			$cats_arr         = array();

			if ( ! empty( $current_post_obj ) && is_object( $current_post_obj ) ) {

				$post_tags = get_the_terms( $current_post_obj->ID, 'dsign_portfolio_tag' );
				if ( ! empty( $post_tags ) && ! is_wp_error( $post_tags ) ) {
					foreach ( $post_tags as $tags ) {
						$tags_arr[] = $tags->term_id;
					}
				}

				$post_cats = get_the_terms( $current_post_obj->ID, 'dsign_portfolio_category' );
				if ( ! empty( $post_cats ) && ! is_wp_error( $post_cats ) ) {
					foreach ( $post_cats as $cat ) {
						$cats_arr[] = $cat->term_id;
					}
				}

				$dsignfly_related_posts_data = get_posts(
					array(
						'post_type'   => 'dsign_portfolio',
						'numberposts' => 6,
						'post_status' => 'publish',
						'tax_query'   => array( // phpcs:ignore
							'relation' => 'OR',
							array(
								'taxonomy' => 'dsign_portfolio_tag',
								'field'    => 'term_id',
								'terms'    => $tags_arr,
							),
							array(
								'taxonomy' => 'dsign_portfolio_category',
								'field'    => 'term_id',
								'terms'    => $cats_arr,
							),
						),
					)
				);

				if ( ! empty( $dsignfly_related_posts_data ) ) {
					$dsignfly_related_post_counter = 0;
					echo '<div id="dsignfly-related-posts-sidebar-widget-content">';
					foreach ( $dsignfly_related_posts_data as $related_post ) {
						$related_post_id = $related_post->ID;
						if ( $related_post_id === $current_post_obj->ID || $dsignfly_related_post_counter >= 5 ) {
							continue;
						}
						?>
						<div class="dsignfly-related-posts-item" onclick="location.href='<?php echo esc_url( get_permalink( $related_post_id ) ); ?>'">
							<?php
							if ( has_post_thumbnail( $related_post_id ) ) {
								echo get_the_post_thumbnail(
									$related_post_id,
									'post-thumbnail',
									array( 'class' => 'dsignfly-related-posts-mini-image dsign-cursor-pointer' )
								);
							} else {
								echo '<img class="dsignfly-recent-posts-mini-image dsign-cursor-pointer"
									src="' . esc_url( dsignfly_default_img_src() ) . '" alt="">';
							}
							?>
							<div class="dsignfly-related-posts-body font-regular">
								<p class="dsignfly-related-post-title dsign-cursor-pointer"> <?php echo esc_html( get_the_title( $related_post_id ) ); ?> </p>
								<div class="dsignfly-related-posts-body-author">
									<?php esc_html_e( 'by', 'dsignfly-theme' ); ?>
									<a href="<?php echo esc_url( get_author_posts_url( $related_post->post_author ) ); ?>"
										id="dsignfly-author-link" class="dsignfly-orange-link">
										<?php echo esc_html( get_the_author_meta( 'display_name', $related_post->post_author ) ); ?>
									</a>
									<?php echo esc_html__( 'on ', 'dsignfly-theme' ) . get_the_date( 'j F, Y', $related_post_id ); ?>
								</div>
							</div>
						</div>
						<?php
						$dsignfly_related_post_counter++;
					}
					echo '</div>';
				} else {
					echo '<h4 class="font-regular not-found">' . esc_html__( 'No post found...', 'dsignfly-theme' ) . '</h4>';
				}
			}

			echo '</div>';
			echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
		}
	}

	/**
	 * Dsignfly Related Posts Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default value.
		$title = __( 'Related Posts', 'dsignfly-theme' );
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
	 * Dsignfly Related Posts Widget Instance Update
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
