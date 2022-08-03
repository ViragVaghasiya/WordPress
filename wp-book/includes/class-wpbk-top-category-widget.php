<?php
/**
 * Top Category Widget
 *
 * @package wpbook
 */

/**
 * Defines top 5 category dashboard widget
 */
class WPBk_Top_Category_Widget {

	/**
	 * Adds top 5 category Dashboard widget
	 *
	 * @return void
	 */
	public function wpbk_top_category_dashboard_widget() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget(
			'wpbk_top_category_widget',
			'Top 5 Book Categories',
			array( $this, 'wpbk_top_category_widget_content' ),
			null,
			null,
			'normal',
			'high'
		);
	}

	/**
	 * Adds top 5 category dashboard widget content
	 *
	 * @return void|Exception
	 */
	public function wpbk_top_category_widget_content() {
		$args = array(
			'show_count' => 1,
			'hide_empty' => 1,
			'taxonomy'   => array( 'wpbk_book_category' ),
			'depth'      => 1,
			'title_li'   => '',
		);

		if ( class_exists( 'WPBk_DB_IO' ) ) {
			try {
				$wpbk_db_io = new WPBk_DB_IO();
				$cats       = $wpbk_db_io->wpbk_top_categories_by_posts( $args );
				unset( $wpbk_db_io );

				if ( ! empty( $cats ) && 'array' === gettype( $cats ) ) {
					usort(
						$cats,
						function( $a, $b ) {
							return $b->category_count <=> $a->category_count;
						}
					);
					$cats = array_slice( $cats, 0, 5 );
					?>
					<ul> 
					<?php
					foreach ( $cats as $category ) {
						?>
						<li>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>">
							<?php echo esc_html( $category->name . ' ( ' . $category->category_count . ' )' ); ?> </a>
						</li>
						<?php
					}
					?>
					</ul>
					<?php
				}
			} catch ( Exception $e ) {
				return $e;
			}
		}
	}

	/**
	 * Action to add top 5 category dashboard widget
	 *
	 * @return void
	 */
	public function wpbk_add_top_category_dashboard_widget() {
		add_action( 'wp_dashboard_setup', array( $this, 'wpbk_top_category_dashboard_widget' ) );
	}
}
