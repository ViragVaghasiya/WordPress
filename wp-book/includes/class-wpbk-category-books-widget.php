<?php
/**
 * Handles Category Books Widget Operations
 *
 * @package wpbook
 */

/**
 * Category Books Widget
 */
class WPBk_Category_Books_Widget extends WP_Widget {

	/**
	 * Initializes the widget
	 */
	public function __construct() {
		parent::__construct(
			'wpbk_book_category_widget',
			esc_html__( 'WP Book Category Widget', 'wpbk' ),
			array( 'description' => esc_html__( 'Displays Books Related to Selected Category', 'wpbk' ) )
		);
	}

	/**
	 * Displays data as widget content in frontend
	 *
	 * @param array $args : widget arguments.
	 * @param array $instance : widget instance variable.
	 * @return void
	 */
	public function widget( $args, $instance ) {

		echo $args['before_widget']; // phpcs:ignore
		if ( ! empty( $instance['categories'] ) ) {
			$cat_id = (int) $instance['categories'];

			if ( ! empty( $cat_id ) ) {
				$term_info = get_term( $instance['categories'] );
				if ( ! empty( $term_info ) ) {

					$cat_name = $term_info->name;
					/* translators: %s: Category Name */
					$title = sprintf( __( 'Best of %s Books', 'wpbk' ), $cat_name );

					echo $args['before_title'] . apply_filters( 'widget_title', esc_html( $title ) ) . $args['after_title']; // phpcs:ignore

					$post_args = array(
						'numberposts' => 10,
						'post_type'   => 'wpbk_book',
						'tax_query'   => array(
							array(
								'taxonomy' => $term_info->taxonomy,
								'field'    => 'term_id',
								'terms'    => $cat_id,
							),
						),
					);
					try {
						$cat_posts = get_posts( $post_args );

						if ( ! empty( $cat_posts ) ) {
							echo '<ul>';
							foreach ( $cat_posts as $post ) {
								echo '<li> <a href="' . esc_attr( get_permalink( $post->ID ) ) . '"> ' . esc_html( $post->post_title ) . ' </a> </li>';
							}
							echo '</ul>';
						}
					} catch ( Exception $e ) {
						esc_html_e( 'Error Fetching Posts...' );
					}
				}
			}
		}
		echo $args['after_widget']; // phpcs:ignore
	}

	/**
	 * Admin side widget form
	 *
	 * @param array $instance : widget instance variable.
	 * @return void
	 */
	public function form( $instance ) {

		$selected_cat = ! empty( $instance['categories'] ) ? $instance['categories'] : esc_html( '' );

		$args = array(
			'hide_empty' => 1,
			'taxonomy'   => array( 'category', 'wpbk_book_category' ),
			'depth'      => 1,
			'title_li'   => '',
		);

		echo '<p>';
		echo '<label for=' . esc_attr( $this->get_field_id( 'categories' ) ) . '>' .
			esc_html__( 'Choose Category to display posts from :', 'wpbk' ) . '</label>';

		$all_categories = get_categories( $args );
		if ( ! empty( $all_categories ) ) {
			if ( empty( $selected_cat ) ) {
				$selected_cat = $all_categories[0]->term_id;
			}
			echo "<select id='" . esc_attr( $this->get_field_id( 'categories' ) ) .
			"' name='" . esc_attr( $this->get_field_name( 'categories' ) ) . "' type='text'>";
			foreach ( $all_categories as $category ) {
				$value = $category->cat_ID;
				echo '<option value=' . esc_attr( $value ) .
					selected( $selected_cat, $value, false ) . '>' .
					esc_html( $category->cat_name ) . '</option>';
			}
			echo '</select>';
		}

		echo '</p>';
	}

	/**
	 * Updates the instance for the widget
	 *
	 * @param array|null $new_instance : new instance variable.
	 * @param array|null $old_instance : old instance variable.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {

		$instance               = array();
		$instance['categories'] = ( ! empty( $new_instance['categories'] ) ) ? wp_strip_all_tags( $new_instance['categories'] ) : '';
		return $instance;
	}

	/**
	 * Registers custom widgret
	 *
	 * @return void
	 */
	public function wpbk_register_category_widget() {
		register_widget( $this );
	}

	/**
	 * Loads custom  widgret
	 *
	 * @return void
	 */
	public function wpbk_load_category_widget() {
		add_action( 'widgets_init', array( $this, 'wpbk_register_category_widget' ) );
	}
}
