<?php
/**
 * Dsignfly Theme's Core Functions.
 *
 * @package Dsignfly
 */

// get the version of dsignfly theme.
$version = wp_get_theme()->get( 'version' );

define( 'POST_ALLOWED_HTML_TAGS', wp_kses_allowed_html( 'post' ) );

/**
 * Adds theme support.
 *
 * @return void
 */
function dsignfly_added_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 300, 210, true );
	add_theme_support( 'widgets' );
}
add_action( 'after_setup_theme', 'dsignfly_added_theme_support' );

/**
 * Registers & Create Dsignfly Navigation Menu
 *
 * @return void
 */
function dsignfly_nav_menu() {

	register_nav_menu( 'primary', __( 'Dsignfly Top Navigation Menu', 'dsignfly-theme' ) );

	$menu_name     = 'Dsignfly Top Navigation Menu';
	$menu_location = 'primary';
	$menu_exists   = wp_get_nav_menu_object( $menu_name );

	if ( ! $menu_exists ) {

		$menu_id = wp_create_nav_menu( $menu_name );
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'   => __( 'Home', 'dsignfly-theme' ),
				'menu-item-classes' => 'home',
				'menu-item-url'     => home_url( '/' ),
				'menu-item-status'  => 'publish',
			)
		);

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'   => __( 'Services', 'dsignfly-theme' ),
				'menu-item-classes' => 'services',
				'menu-item-status'  => 'publish',
			)
		);

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'   => __( 'Portfolio', 'dsignfly-theme' ),
				'menu-item-classes' => 'portfolio',
				'menu-item-url'     => home_url( '/portfolio/' ),
				'menu-item-status'  => 'publish',
			)
		);

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'   => __( 'Blog', 'dsignfly-theme' ),
				'menu-item-classes' => 'blog',
				'menu-item-url'     => home_url( '/blog/' ),
				'menu-item-status'  => 'publish',
			)
		);

		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'   => __( 'Contact', 'dsignfly-theme' ),
				'menu-item-classes' => 'contact',
				'menu-item-status'  => 'publish',
			)
		);

		if ( ! has_nav_menu( $menu_location ) ) {
			$locations                   = get_theme_mod( 'nav_menu_locations' );
			$locations[ $menu_location ] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
	}
}
add_action( 'init', 'dsignfly_nav_menu' );


/**
 * Dsignfly Top Navigation Logo
 *
 * @return string
 */
function get_dsignfly_logo() {

	if ( has_custom_logo() ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		return '<img src="' . esc_url( $logo[0] ) . '" alt="' . "D'SIGNfly" . '">';
	} else {
		return '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/logo.png' ) . '" alt="' . "D'SIGNfly" . '">';
	}
}

/**
 * Enqueues stylesheets and fonts
 *
 * @return void
 */
function dsignfly_css() {

	global $version;

	// main stylesheet.
	wp_register_style(
		'dsignfly_custom_css',
		esc_url( get_template_directory_uri() . '/style.css' ),
		array(),
		$version
	);
	wp_enqueue_style( 'dsignfly_custom_css' );

	// google fonts stylesheet.
	wp_register_style(
		'dsignfly_fonts_css',
		esc_url( 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap' ),
		array(),
		1.0
	);
	wp_enqueue_style( 'dsignfly_fonts_css' );

	// portfolio page css.
	wp_register_style(
		'dsignfly_portfolio_page_css',
		esc_url( get_template_directory_uri() . '/assets/css/portfolio-style.css' ),
		array(),
		$version
	);
	wp_enqueue_style( 'dsignfly_portfolio_page_css' );

	// blog page css.
	wp_register_style(
		'dsignfly_blog_page_css',
		esc_url( get_template_directory_uri() . '/assets/css/blog-style.css' ),
		array(),
		$version
	);
	wp_enqueue_style( 'dsignfly_blog_page_css' );

	// single post page css.
	wp_register_style(
		'dsignfly_single_post_page_css',
		esc_url( get_template_directory_uri() . '/assets/css/single-style.css' ),
		array(),
		$version
	);
	wp_enqueue_style( 'dsignfly_single_post_page_css' );
}
add_action( 'wp_enqueue_scripts', 'dsignfly_css' );

/**
 * Enqueues JavaScript Files
 *
 * @return void
 */
function dsignfly_js() {

	global $version;

	// enqueues jquery.
	wp_enqueue_script( 'jquery' );

	// homepage js.
	wp_register_script(
		'homepage_js',
		esc_url( get_template_directory_uri() . '/assets/js/homepage-custom.js' ),
		array( 'jquery' ),
		$version,
		true
	);
	wp_enqueue_script( 'homepage_js' );

	// portfolio page js.
	wp_register_script(
		'portfolio_page_js',
		esc_url( get_template_directory_uri() . '/assets/js/portfolio-page-custom.js' ),
		array( 'jquery' ),
		$version,
		true
	);
	wp_localize_script(
		'portfolio_page_js',
		'dsignfly_ajax_object',
		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
	);
	wp_enqueue_script( 'portfolio_page_js' );
}
add_action( 'wp_enqueue_scripts', 'dsignfly_js' );

/**
 * Regiters custom post type
 *
 * @throws Exception $e .
 * @return void
 */
function dsignfly_post_type_portfolio() {

	$supports = array(
		'title',
		'editor',
		'author',
		'thumbnail',
		'excerpt',
		'custom-fields',
		'comments',
		'revisions',
		'post-formats',
	);

	$labels = array(
		'name'           => _x( 'portfolio', 'plural', 'dsignfly-theme' ),
		'singular_name'  => _x( 'portfolio', 'singular', 'dsignfly-theme' ),
		'menu_name'      => _x( 'portfolio', 'admin menu', 'dsignfly-theme' ),
		'name_admin_bar' => _x( 'portfolio', 'admin bar', 'dsignfly-theme' ),
		'add_new'        => _x( 'Add New', 'add new', 'dsignfly-theme' ),
		'add_new_item'   => __( 'Add New portfolio', 'dsignfly-theme' ),
		'new_item'       => __( 'New portfolio', 'dsignfly-theme' ),
		'edit_item'      => __( 'Edit portfolio', 'dsignfly-theme' ),
		'view_item'      => __( 'View portfolio', 'dsignfly-theme' ),
		'all_items'      => __( 'All portfolio', 'dsignfly-theme' ),
		'search_items'   => __( 'Search portfolio', 'dsignfly-theme' ),
		'not_found'      => __( 'No portfolio found.', 'dsignfly-theme' ),
	);

	$args = array(
		'supports'            => $supports,
		'labels'              => $labels,
		'public'              => true,
		'taxonomies'          => array( 'dsign_portfolio_category', 'dsign_portfolio_tag' ),
		'query_var'           => true,
		'rewrite'             => array( 'slug' => 'dsign-portfolio' ),
		'has_archive'         => true,
		'show_in_menu'        => true,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'show_in_admin_bar'   => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
	);

	try {
		register_post_type( 'dsign_portfolio', $args );
	} catch ( Exception $e ) {
		wp_die( esc_html( $e->getMessage() ) );
	}

}
add_action( 'init', 'dsignfly_post_type_portfolio' );

/**
 * Creates Custom Pages
 *
 * @return void
 */
function dsignfly_custom_pages() {

	$check_page_exist = get_page_by_title( 'portfolio', 'OBJECT', 'page' );

	// Check if the page already exists.
	if ( empty( $check_page_exist ) ) {
		wp_insert_post(
			array(
				'comment_status' => 'close',
				'ping_status'    => 'close',
				'post_author'    => 1,
				'post_title'     => ucwords( 'portfolio' ),
				'post_name'      => strtolower( str_replace( ' ', '-', trim( 'portfolio' ) ) ),
				'post_status'    => 'publish',
				'post_content'   => '',
				'post_type'      => 'page',
			)
		);
	}

	$check_page_exist = get_page_by_title( 'blog', 'OBJECT', 'page' );
	// Check if the page already exists.
	if ( empty( $check_page_exist ) ) {
		wp_insert_post(
			array(
				'comment_status' => 'close',
				'ping_status'    => 'close',
				'post_author'    => 1,
				'post_title'     => ucwords( 'blog' ),
				'post_name'      => strtolower( str_replace( ' ', '-', trim( 'blog' ) ) ),
				'post_status'    => 'publish',
				'post_content'   => '',
				'post_type'      => 'page',
			)
		);
	}
}
add_action( 'after_setup_theme', 'dsignfly_custom_pages' );

/**
 * Creates Custom Category Taxonomy
 *
 * @throws Exception $e.
 * @return void
 */
function dsign_portfolio_category_heirarchichal_taxonomy() {

	try {
		// Sets UI labels for Custom heirarchichal taxonomy.
		$labels = array(
			'name'              => _x( 'Portfolio Categories', 'taxonomy general name', 'dsignfly-theme' ),
			'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'dsignfly-theme' ),
			'search_items'      => __( 'Search portfolio Category', 'dsignfly-theme' ),
			'all_items'         => __( 'All portfolio Category', 'dsignfly-theme' ),
			'parent_item'       => __( 'Parent portfolio Category', 'dsignfly-theme' ),
			'parent_item_colon' => __( 'Parent portfolio Category:', 'dsignfly-theme' ),
			'edit_item'         => __( 'Edit portfolio Category', 'dsignfly-theme' ),
			'update_item'       => __( 'Update portfolio Category', 'dsignfly-theme' ),
			'add_new_item'      => __( 'Add New portfolio Category', 'dsignfly-theme' ),
			'new_item_name'     => __( 'New portfolio Category Name', 'dsignfly-theme' ),
			'menu_name'         => __( 'Portfolio Category', 'dsignfly-theme' ),
		);

		// registers the taxonomy.
		register_taxonomy(
			'dsign_portfolio_category',
			array( 'dsign_portfolio' ),
			array(
				'hierarchical'      => true,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'dsign-portfolio-category' ),
			)
		);
	} catch ( Exception $e ) {
		wp_die( esc_html( $e->getMessage() ) );
	}
}
add_action( 'init', 'dsign_portfolio_category_heirarchichal_taxonomy' );

/**
 * Creates Custom Tag Taxonomy
 *
 * @throws Exception $e.
 * @return void
 */
function dsignfly_portfolio_tag_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Tags', 'taxonomy general name', 'dsignfly-theme' ),
		'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'dsignfly-theme' ),
		'search_items'               => __( 'Search Tags', 'dsignfly-theme' ),
		'popular_items'              => __( 'Popular Tags', 'dsignfly-theme' ),
		'all_items'                  => __( 'All Tags', 'dsignfly-theme' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Tag', 'dsignfly-theme' ),
		'update_item'                => __( 'Update Tag', 'dsignfly-theme' ),
		'add_new_item'               => __( 'Add New Tag', 'dsignfly-theme' ),
		'new_item_name'              => __( 'New Tag Name', 'dsignfly-theme' ),
		'separate_items_with_commas' => __( 'Separate tags with commas', 'dsignfly-theme' ),
		'add_or_remove_items'        => __( 'Add or remove tags', 'dsignfly-theme' ),
		'choose_from_most_used'      => __( 'Choose from the most used tags', 'dsignfly-theme' ),
		'menu_name'                  => __( 'Portfolio Tags', 'dsignfly-theme' ),
	);

	try {
		register_taxonomy(
			'dsign_portfolio_tag',
			array( 'dsign_portfolio' ),
			array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_in_rest'          => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'dsign-portfolio-tag' ),
			)
		);
	} catch ( Exception $e ) {
		wp_die( esc_html( $e->getMessage() ) );
	}
}
add_action( 'init', 'dsignfly_portfolio_tag_taxonomy' );

/**
 * Creates Custom Categories
 *
 * @return void
 */
function dsignfly_insert_category() {
	wp_insert_term(
		'Advertising',
		'dsign_portfolio_category',
		array(
			'slug'        => 'dsign-advertising',
			'description' => __(
				'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias distinctio nam debitis similiqu',
				'dsignfly-theme'
			),
		)
	);
	wp_insert_term(
		'Multimedia',
		'dsign_portfolio_category',
		array(
			'slug'        => 'dsign-multimedia',
			'description' => __(
				'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias distinctio nam debitis similiqu',
				'dsignfly-theme'
			),
		)
	);
	wp_insert_term(
		'Photography',
		'dsign_portfolio_category',
		array(
			'slug'        => 'dsign-photography',
			'description' => __(
				'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestias distinctio nam debitis similiqu',
				'dsignfly-theme'
			),
		)
	);
}
add_action( 'init', 'dsignfly_insert_category' );

/**
 * Includes custom post type in main query
 *
 * @param object $query post query.
 * @return void
 */
function dsignfly_set_post_type( $query ) {

	if ( ! is_admin() && $query->is_main_query() ) {
		$query->set( 'post_type', array( 'dsign_portfolio', 'page' ) );
		$query->set( 'posts_per_page', '5' );
	}
}
add_action( 'pre_get_posts', 'dsignfly_set_post_type', 10, 1 );

/**
 * Returns pagination links
 *
 * @param int            $max_page maximum no of pages.
 * @param boolean|string $url_var url variable for categories on portfolio page.
 * @return string|void
 */
function pagination_bar( $max_page, $url_var = false ) {

	if ( ! empty( $max_page ) ) {
		if ( $max_page > 1 ) {
			$current_page = max( 1, get_query_var( 'paged' ) );

			$pagination_arr = array(
				'base'      => str_replace( $max_page + 1, '%#%', get_pagenum_link( $max_page + 1 ) ),
				'format'    => 'page/%#%',
				'current'   => $current_page,
				'total'     => $max_page,
				'prev_text' => '<img class="dsignfly-pagination-prev"
					src="' . esc_url( get_template_directory_uri() . '/assets/images/pagination-arrow.png' ) . '"
					alt="">',
				'next_text' => '<img class="dsignfly-pagination-next"
					src="' . esc_url( get_template_directory_uri() . '/assets/images/pagination-arrow.png' ) . '"
					alt="">',
			);

			if ( $url_var ) {
				$pagination_arr['add_args'] = array( 'dsign-cat' => $url_var );
			}
			return paginate_links( $pagination_arr );
		}
	}
}

/**
 * Custom Comment Format
 *
 * @param mixed $comment comment.
 * @param mixed $args comment arguments.
 * @param mixed $depth depth variable.
 * @return void
 */
function dsignfly_comments_format( $comment, $args, $depth ) {
	if ( 'div' === $args['style'] ) {
		$tag       = 'div';
		$add_below = 'comment';
	} else {
		$tag       = 'li';
		$add_below = 'div-comment';
	}
	?>
	<<?php echo wp_kses( $tag, POST_ALLOWED_HTML_TAGS ); ?>
		<?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>
		id="comment-<?php esc_attr( comment_ID() ); ?>">
	<?php if ( 'div' !== $args['style'] ) : ?>
		<div id="div-comment-<?php esc_attr( comment_ID() ); ?>" class=" dsignfly-single-post-comment comment-body">
	<?php endif; ?>
			<div class="comment-author vcard">
				<img class="dsignfly-comment-icon" 
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/comments.png' ); ?>" alt="">
				<?php
				printf(
					'<a id="dsignfly-comment-author-link"
						href="' . esc_url( get_comment_author_url() ) . ' " class="dsignfly-orange-link"> ' .
						esc_html( get_comment_author() ) . ' ' .
					'</a> ' .
					' <span class="says">' . esc_html__( 'said on', 'dsignfly-theme' ) . ' </span>'
				);

				printf(
					/* translators: 1: Comment Date 2: Comment Time */
					esc_html__( '%1$s at %2$s' ),
					esc_html( get_comment_date() ),
					esc_html( get_comment_time() )
				);
				?>
			</div>
			<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation">
					<?php esc_html_e( 'Your comment is awaiting moderation.', 'dsignfly-theme' ); ?>
				</em>
				<br/> 
			<?php endif; ?>

			<div class="dsignfly-comment-content-body" >
				<?php comment_text(); ?>
			</div>

			<div id="dsignfly-comment-reply-link" class="reply">
				<img class="dsignfly-comment-icon"
					src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/reply-arrow.png' ); ?>" alt="">
				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => __( 'reply', 'dsignfly-theme' ),
							'add_below'  => $add_below,
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						),
					),
				);
				?>
			</div>
		<?php if ( 'div' !== $args['style'] ) : ?>
			</div>
		<?php endif; ?>
		<?php
}

// adds dsignfly widget classes.
require_once 'classes/class-dsignfly-portfolio-widget.php';
require_once 'classes/class-dsignfly-related-posts-widget.php';
require_once 'classes/class-dsignfly-popular-posts-widget.php';
require_once 'classes/class-dsignfly-recent-posts-widget.php';
require_once 'classes/class-dsignfly-twitter.php';
require_once 'classes/class-dsignfly-facebook.php';
require_once 'classes/class-dsignfly-archive-widget.php';

/**
 * Registers Dsignfly Sidebar & Widgets
 *
 * @return void
 */
function register_dsignfly_widget_area() {
	register_sidebar(
		array(
			'id'          => 'dsignfly-sidebar',
			'name'        => esc_html__( 'Dsignfly Sidebar Widget Area', 'dsignfly-theme' ),
			'description' => esc_html__( 'A widget area made for dsignfly widgets', 'dsignfly-theme' ),
		)
	);

	register_widget( 'Dsignfly_Portfolio_Widget' );
	register_widget( 'Dsignfly_Related_Posts_Widget' );
	register_widget( 'Dsignfly_Popular_Posts_Widget' );
	register_widget( 'Dsignfly_Recent_Posts_Widget' );
	register_widget( 'Dsignfly_Twitter' );
	register_widget( 'Dsignfly_Facebook' );
	register_widget( 'Dsignfly_Archive_Widget' );
}
add_action( 'widgets_init', 'register_dsignfly_widget_area', 7 );

/**
 * Sets Post View for popular posts widget
 *
 * @param int $post_id id of the post.
 * @return void
 */
function dsignfly_set_post_views( $post_id ) {
	$count_key = 'dsignfly_post_views_count';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( '' === $count ) {
		$count = 0;
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
	} else {
		$count++;
		update_post_meta( $post_id, $count_key, $count );
	}
}
// To keep the count accurate, gets rid of prefetching.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

/**
 * Tracks post view for popular post widget
 *
 * @param int $post_id id of the post.
 * @return void
 */
function dsignfly_track_post_views( $post_id ) {
	if ( ! is_single() ) {
		return;
	}
	if ( empty( $post_id ) ) {
		global $post;
		$post_id = $post->ID;
	}
	dsignfly_set_post_views( $post_id );
}
add_action( 'wp_head', 'dsignfly_track_post_views' );

/**
 * Gets post view for popular posts widget
 *
 * @param int $post_id id of the post.
 * @return string
 */
function dsignfly_get_post_views( $post_id ) {
	$count_key = 'wpb_post_views_count';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( '' === $count ) {
		delete_post_meta( $post_id, $count_key );
		add_post_meta( $post_id, $count_key, '0' );
		return '0 View';
	}
	return $count . ' Views ';
}

/**
 * Default image source for portfolio posts without thumbnail
 *
 * @return string
 */
function dsignfly_default_img_src() {
	return get_template_directory_uri() . '/assets/images/default-thumbnail.jpg';
}

/**
 * Adds custom arguments to archive widget
 *
 * @return array
 */
function custom_widget_archives_args() {
	$args = array(
		'type'      => 'monthly',
		'limit'     => 5,
		'echo'      => 0,
		'before'    => '<h4 class="font-semi-bold dsignfly-archive-widget-item"> &#x276F; ',
		'format'    => 'li',
		'after'     => '</h4>',
		'post_type' => 'dsign_portfolio',
	);
	return $args;
}
add_action( 'widget_archives_args', 'custom_widget_archives_args' );

/**
 * Removes Default Widgets From Sidebar On Theme Switch
 *
 * @return void
 */
function deregister_default_sidebar_widgets() {
	wp_set_sidebars_widgets( array() );
}
add_action( 'after_switch_theme', 'deregister_default_sidebar_widgets' );

/**
 * Adds Default Dsignfly Widgets to Sidebar
 *
 * @return array
 */
function dsignfly_default_widgets() {

	$defaults[] = the_widget(
		'Dsignfly_Portfolio_Widget',
		array( 'title' => __( 'Portfolio', 'dsignfly-theme' ) )
	);
	$defaults[] = the_widget(
		'Dsignfly_Related_Posts_Widget',
		array( 'title' => __( 'Related Posts', 'dsignfly-theme' ) )
	);
	$defaults[] = the_widget(
		'Dsignfly_Recent_Posts_Widget',
		array( 'title' => __( 'Recent Posts', 'dsignfly-theme' ) )
	);
	$defaults[] = the_widget(
		'Dsignfly_Popular_Posts_Widget',
		array( 'title' => __( 'Popular Posts', 'dsignfly-theme' ) )
	);
	$defaults[] = the_widget(
		'Dsignfly_Archive_Widget',
		array(
			'title'    => __( 'Archives', 'dsignfly-theme' ),
			'arc_type' => 'monthly',
		)
	);
	$defaults[] = the_widget(
		'Dsignfly_Twitter',
		array(
			'title'       => __( 'Latest Tweet', 'dsignfly-theme' ),
			'twitter_url' => esc_url( 'https://twitter.com/automattic' ),
		)
	);
	$defaults[] = the_widget(
		'Dsignfly_Facebook',
		array(
			'title'  => '',
			'fb_url' => esc_url( 'https://www.facebook.com/AutomatticInc/' ),
		)
	);

	return $defaults;
}

// adds customizer class.
require_once 'inc/class-dsignfly-customizer-settings.php';

// adds designfly theme's customizer settings and sections.
if ( class_exists( 'Dsignfly_Customizer_Settings' ) ) {
	new Dsignfly_Customizer_Settings();
}

