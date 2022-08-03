<?php
/**
 * Dsignfly Portfolio Widget Handling.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Portfolio Posts Widget
 */
class Dsignfly_Portfolio_Widget extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'dsign_portfolio_widget',
			__( 'Dsignfly Portfolio Widget', 'dsignfly-theme' ),
			array( 'description' => __( 'Sidebar widget for latest portfolio posts', 'dsignfly-theme' ) )
		);
	}

	/**
	 * Dsignfly Portfolio Posts Widget Content
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

		$dsignfly_portfolio_widget_posts = get_posts(
			array(
				'post_type'   => 'dsign_portfolio',
				'numberposts' => 8,
				'fields'      => 'ids',
				'meta_query'  => array( // phpcs:ignore
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				),
			)
		);

		if ( ! empty( $dsignfly_portfolio_widget_posts ) ) {
			echo '<div id="dsignfly-portfolio-sidebar-widget-content">';
			foreach ( $dsignfly_portfolio_widget_posts as $portfolio_post_id ) {
				if ( has_post_thumbnail( $portfolio_post_id ) ) {
					echo get_the_post_thumbnail(
						$portfolio_post_id,
						'post-thumbnail',
						array(
							'class'   => 'dsignfly-portfolio-mini-image dsign-cursor-pointer',
							'onclick' => 'location.href = "' . esc_url( get_permalink( get_page_by_path( 'portfolio' ) ) ) . '"',
						)
					);
				}
			}
			echo '</div>';
		} else {
			echo '<h4 class="font-regular not-found">' . esc_html__( 'No post found...', 'dsignfly-theme' ) . '</h4>';
		}
		echo '</div>';
		echo wp_kses( $args['after_widget'], POST_ALLOWED_HTML_TAGS );
	}

	/**
	 * Dsignfly Portfolio Posts Widget Form
	 *
	 * @param array $instance instance variables array.
	 * @return void
	 */
	public function form( $instance ) {

		// default value.
		$title = __( 'Portfolio', 'dsignfly-theme' );

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
	 * Dsignfly Portfolio Posts Widget Instance Update
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
