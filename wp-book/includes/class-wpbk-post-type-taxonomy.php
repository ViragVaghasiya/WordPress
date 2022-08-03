<?php
/**
 * Creates custom taxonomies and post type
 *
 * @package wpbook
 */

// denies direct access.
if ( ! defined( 'WPINC' ) ) {
	die( 'No direct access.' );
}

/**
 * Creates Custom Post Type : Book
 * Creates Custom Non-hierarchichal Taxonomy : Book Tag
 * Creates Custom hierarchichal Taxonomy : Book Category
 */
class WPBk_Post_Type_Taxonomy {

	/**
	 * Creates custom post type : Book
	 */
	public function wpbk_book_post_type() {

		try {
			// Sets UI labels for Custom Post Type.
			$labels = array(
				'name'               => _x( 'Books', 'Post Type General Name', 'wpbk' ),
				'singular_name'      => _x( 'Book', 'Post Type Singular Name', 'wpbk' ),
				'menu_name'          => __( 'Books', 'wpbk' ),
				'parent_item_colon'  => __( 'Parent Book', 'wpbk' ),
				'all_items'          => __( 'All Books', 'wpbk' ),
				'view_item'          => __( 'View Book', 'wpbk' ),
				'add_new_item'       => __( 'Add New Book', 'wpbk' ),
				'add_new'            => __( 'Add New', 'wpbk' ),
				'edit_item'          => __( 'Edit Book', 'wpbk' ),
				'update_item'        => __( 'Update Book', 'wpbk' ),
				'search_items'       => __( 'Search Book', 'wpbk' ),
				'not_found'          => __( 'Not Found', 'wpbk' ),
				'not_found_in_trash' => __( 'Not found in Trash', 'wpbk' ),
			);

			// Sets other options for Custom Post Type.
			$args = array(
				'label'               => __( 'Books', 'wpbk' ),
				'description'         => __( 'Book news and reviews', 'wpbk' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
				'taxonomies'          => array( 'wpbk_book_category', 'wpbk_book_tag' ),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'rewrite'             => array( 'slug' => 'wpbk-book' ),
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest'        => true,
			);

			// Registering Custom Post Type.
			register_post_type( 'wpbk_book', $args );
		} catch ( Exception $e ) {
			wp_die( esc_html( $e ) );
		}
	}

	/**
	 * Creates custom heirarchichal taxonomy : Book Category
	 *
	 * @return void
	 */
	public function wpbk_book_category_heirarchichal_taxonomy() {

		try {
			// Sets UI labels for Custom heirarchichal taxonomy.
			$labels = array(
				'name'              => _x( 'Book Categories', 'taxonomy general name', 'wpbk' ),
				'singular_name'     => _x( 'Book Category', 'taxonomy singular name', 'wpbk' ),
				'search_items'      => __( 'Search Book Category', 'wpbk' ),
				'all_items'         => __( 'All Book Category', 'wpbk' ),
				'parent_item'       => __( 'Parent Book Category', 'wpbk' ),
				'parent_item_colon' => __( 'Parent Book Category:', 'wpbk' ),
				'edit_item'         => __( 'Edit Book Category', 'wpbk' ),
				'update_item'       => __( 'Update Book Category', 'wpbk' ),
				'add_new_item'      => __( 'Add New Book Category', 'wpbk' ),
				'new_item_name'     => __( 'New Book Category Name', 'wpbk' ),
				'menu_name'         => __( 'Book Categories', 'wpbk' ),
			);

			// registers the taxonomy.
			register_taxonomy(
				'wpbk_book_category',
				array( 'wpbk_book' ),
				array(
					'hierarchical'      => true,
					'labels'            => $labels,
					'show_ui'           => true,
					'show_in_rest'      => true,
					'show_admin_column' => true,
					'query_var'         => true,
					'rewrite'           => array( 'slug' => 'wpbk-book-category' ),
				)
			);
		} catch ( Exception $e ) {
			wp_die( esc_html( $e ) );
		}
	}

	/**
	 * Creates custom non-heirarchichal taxonomy : Book Tag
	 *
	 * @return void
	 */
	public function wpbk_book_tag_nonhierarchical_taxonomy() {

		try {
			// Sets UI labels for non-heirarchical taxonomy.
			$labels = array(
				'name'                       => _x( 'Book Tags', 'taxonomy general name', 'wpbk' ),
				'singular_name'              => _x( 'Book Tag', 'taxonomy singular name', 'wpbk' ),
				'search_items'               => __( 'Search Book Tags', 'wpbk' ),
				'popular_items'              => __( 'Popular Book Tags', 'wpbk' ),
				'all_items'                  => __( 'All Book Tags', 'wpbk' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Book Tag', 'wpbk' ),
				'update_item'                => __( 'Update Book Tag', 'wpbk' ),
				'add_new_item'               => __( 'Add New Book Tag', 'wpbk' ),
				'new_item_name'              => __( 'New Book Tag Name', 'wpbk' ),
				'separate_items_with_commas' => __( 'Separate Book Tags with commas', 'wpbk' ),
				'add_or_remove_items'        => __( 'Add or remove Book Tags', 'wpbk' ),
				'choose_from_most_used'      => __( 'Choose from the most used Book Tags', 'wpbk' ),
				'menu_name'                  => __( 'Book Tags', 'wpbk' ),
			);

			// Now register the non-hierarchical taxonomy.
			register_taxonomy(
				'wpbk_book_tag',
				array( 'wpbk_book' ),
				array(
					'hierarchical'          => false,
					'labels'                => $labels,
					'show_ui'               => true,
					'show_in_rest'          => true,
					'show_admin_column'     => true,
					'update_count_callback' => '_update_post_term_count',
					'query_var'             => true,
					'rewrite'               => array( 'slug' => 'wpbk-book-tag' ),
				)
			);
		} catch ( Exception $e ) {
			wp_die( esc_html( $e ) );
		}
	}

	/**
	 * Action to register book post type
	 *
	 * @return void
	 */
	public function wpbk_rgstr_book_post_type() {
		add_action( 'init', array( $this, 'wpbk_book_post_type' ) );
	}

	/**
	 * Action to register book category taxonomy
	 *
	 * @return void
	 */
	public function wpbk_rgstr_book_ctgr_taxonomy() {
		add_action( 'init', array( $this, 'wpbk_book_category_heirarchichal_taxonomy' ) );
	}

	/**
	 * Action to register book tag taxonomy
	 *
	 * @return void
	 */
	public function wpbk_rgstr_book_tag_taxonomy() {
		add_action( 'init', array( $this, 'wpbk_book_tag_nonhierarchical_taxonomy' ) );
	}
}
