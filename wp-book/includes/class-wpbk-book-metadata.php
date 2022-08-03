<?php
/**
 * Handles custom metabox related operations
 *
 * @package wpbook
 */

// denies direct access.
if ( ! defined( 'WPINC' ) ) {
	die( 'No direct access.' );
}

/**
 * Adds bookmeta boxes and admin settings
 */
class WPBk_Book_Metadata {
	/**
	 * Registers bookmeta form css and js
	 *
	 * @return void
	 */
	public function wpbk_book_form_register_assets() {
		wp_enqueue_style( 'book-info-form-css', WPBK_ASSETS_URL . '/css/book-info-form.css', '', WPBK_VERSION );
		wp_register_script(
			'book-info-form-ajax-script',
			WPBK_ASSETS_URL . '/js/book-info-form-ajax.js',
			array( 'jquery' ),
			WPBK_VERSION,
			true
		);
		wp_enqueue_script( 'book-info-form-ajax-script' );
		wp_localize_script(
			'book-info-form-ajax-script',
			'wpbk_ajax_object',
			array(
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'ajaxnonce' => wp_create_nonce( 'wpbk_bookinfo_api_nonce' ),
			)
		);
	}

	/**
	 * Book info form fields
	 *
	 * @param object $post : post object.
	 * @return void
	 */
	public function wpbk_book_fields( $post ) {
		$wpbk_db_io = new WPBk_DB_IO();
		require_once WPBK_TEMPLATE_DIR . '/book-info-form-template.php';
		unset( $wpbk_db_io );
	}

	/**
	 * Search book fields
	 *
	 * @param object $post : post object.
	 * @return void
	 */
	public function wpbk_search_book_fields( $post ) {
		require_once WPBK_TEMPLATE_DIR . '/search-autofill-book-info-template.php';
	}

	/**
	 * Adds book meta boxes
	 *
	 * @return void
	 */
	public function wpbk_book_meta_box() {
		add_action( 'admin_enqueue_scripts', array( $this, 'wpbk_book_form_register_assets' ) );
		add_meta_box(
			'wpbk-search-book-information',
			__( 'Search & Autofill Book Information', 'wpbk' ),
			array( $this, 'wpbk_search_book_fields' ),
		);
		add_meta_box(
			'wpbk-book-information',
			__( 'Book Information', 'wpbk' ),
			array( $this, 'wpbk_book_fields' ),
		);
	}

	/**
	 * Registers book meta boxes
	 *
	 * @return void
	 */
	public function wpbk_register_book_meta_box() {
		add_action( 'add_meta_boxes_wpbk_book', array( $this, 'wpbk_book_meta_box' ) );
	}

	/**
	 * Action to save book post meta data
	 *
	 * @return void
	 */
	public function wpbk_save_book_information_action() {
		add_action( 'save_post_wpbk_book', array( $this, 'wpbk_save_book_information' ), 10, 2 );
	}

	/**
	 * Save book post meta data
	 *
	 * @param int $post_id : id of the post.
	 * @return int|void
	 */
	public function wpbk_save_book_information( $post_id ) {

		try {
			// verifies bookmeta form nonce.
			if ( ( ! isset( $_POST['wpbk_save_book_info_nonce'] ) ) ||
				( ! wp_verify_nonce( sanitize_key( $_POST['wpbk_save_book_info_nonce'] ), 'wp_book_form_fields_save_check' ) )
			) {
				return $post_id;
			}

			// Check for autosave.
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return $post_id;
			}

			$wpbk_post_meta_arr                     = array();
			$wpbk_post_meta_arr['wpbk_author_name'] = isset( $_POST['wpbk_author_name'] ) ? sanitize_text_field( $_POST['wpbk_author_name'] ) : '';

			$wpbk_post_meta_arr['wpbk_published_year'] = isset( $_POST['wpbk_published_year'] ) ? intval( $_POST['wpbk_published_year'] ) : '';

			$wpbk_post_meta_arr['wpbk_price'] = isset( $_POST['wpbk_price'] ) ? ( ! empty( $_POST['wpbk_price'] ) ? number_format( floatval( $_POST['wpbk_price'] ), 2 ) : '' ) : '';

			$wpbk_post_meta_arr['wpbk_publisher'] = isset( $_POST['wpbk_publisher'] ) ? sanitize_text_field( $_POST['wpbk_publisher'] ) : '';

			$wpbk_post_meta_arr['wpbk_edition'] = isset( $_POST['wpbk_edition'] ) ? sanitize_text_field( $_POST['wpbk_edition'] ) : '';

			$wpbk_post_meta_arr['wpbk_url'] = isset( $_POST['wpbk_url'] ) ? esc_url_raw( $_POST['wpbk_url'] ) : '';

			$wpbk_post_meta_arr['wpbk_book_pages'] = isset( $_POST['wpbk_book_pages'] ) ? intval( $_POST['wpbk_book_pages'] ) : '';

			$wpbk_post_meta_arr['wpbk_rating'] = isset( $_POST['wpbk_rating'] ) ? ( ! empty( $_POST['wpbk_rating'] ) ? number_format( floatval( $_POST['wpbk_rating'] ), 1 ) : '' ) : '';

			$wpbk_post_meta_arr['wpbk_language'] = isset( $_POST['wpbk_language'] ) ? sanitize_text_field( $_POST['wpbk_language'] ) : '';

			$wpbk_post_meta_arr['wpbk_description'] = isset( $_POST['wpbk_description'] ) ?
				wp_kses(
					$_POST['wpbk_description'],
					array(
						'br'     => array(),
						'em'     => array(),
						'st ong' => array(),
					)
				) : '';

			$wpbk_post_meta_arr['wpbk_currency_unit'] = isset( $_POST['wpbk_currency_unit'] ) ? sanitize_text_field( $_POST['wpbk_currency_unit'] ) : '';

			if ( ! empty( $wpbk_post_meta_arr ) ) {
				$wpbk_db_io = new WPBk_DB_IO();
				$wpbk_db_io->wpbk_save_book_form( $post_id, $wpbk_post_meta_arr );
				unset( $wpbk_db_io );
			}
		} catch ( Exception $e ) {
			return $e;
		}
	}

	/**
	 * Deletes book post
	 *
	 * @param int    $post_id : id of the post.
	 * @param object $post : post object.
	 * @return void|Exception
	 */
	public function wpbk_delete_book_meta_fields( $post_id, $post ) {

		try {
			if ( 'wpbk_book' === $post->post_type ) {
				$wpbk_db_io = new WPBk_DB_IO();
				$meta_keys  = array(
					'wpbk_author_name',
					'wpbk_published_year',
					'wpbk_price',
					'wpbk_publisher',
					'wpbk_edition',
					'wpbk_url',
					'wpbk_country',
					'wpbk_book_pages',
					'wpbk_rating',
					'wpbk_language',
					'wpbk_description',
					'wpbk_currency_unit',
				);
				$wpbk_db_io->delete_wpbk_book_meta( $post_id, $meta_keys );
				unset( $wpbk_db_io );
			}
		} catch ( Exception $e ) {
			return $e;
		}
	}

	/**
	 * Action to delete post
	 *
	 * @return void
	 */
	public function wpbk_delete_book_post_action() {
		add_action( 'delete_post', array( $this, 'wpbk_delete_book_meta_fields' ), 10, 2 );
	}

	/**
	 * Adds custom query before actual query fires
	 *
	 * @param object $query : query object.
	 * @return string|Exception
	 */
	public function wpbk_books_custom_query_init( $query ) {
		try {
			if ( ! is_admin() && $query->is_main_query() && is_home() ) {
				$query->set( 'post_type', array( 'post', 'wpbk_book' ) );

				$no_of_books = get_option( 'wpbk_books_per_page' );
				if ( ! empty( $no_of_books ) || ! '0' === $no_of_books ) {
					$no_of_books = (int) $no_of_books;
					$query->set( 'posts_per_page', $no_of_books );
				}
			}
		} catch ( Exception $e ) {
			return $e;
		}
		return '';
	}

	/**
	 * Adds content to the books posts
	 *
	 * @param string $content : post content.
	 * @return string
	 */
	public function wpbk_filter_content_in_the_main_loop( $content ) {
		try {
			// Check if we're inside the main loop in a single Post.
			if ( is_singular() && is_main_query() && 'wpbk_book' === get_post_type() ) {

				$display_attr = get_option( 'wpbk_book_info_display' );
				if ( empty( $display_attr ) || 'array' !== gettype( $display_attr ) ) {
					return $content;
				} else {
					$display_attr = array_intersect( array_keys( $display_attr ), array_keys( WPBK_BOOKINFO_DISPLAY_OPTIONS ) );
					if ( empty( $display_attr ) ) {
						return $content;
					}
				}

				$wpbk_db_io = new WPBk_DB_IO();

				$content .= "<div class='wpbk-books-sinlge-post-result'>";
				$content .= "
					<div class='wpbk-single-post-book' >
						<table>
				";

				$wpbk_current_post_id = get_the_ID();

				foreach ( $display_attr as $book_attr ) {

					$field_id       = 'wpbk-single-book-' . str_replace( '_', '-', $book_attr );
					$label          = ucwords( str_replace( '_', ' ', $book_attr ) );
					$attr_value     = null;
					$query_variable = 'wpbk_' . $book_attr;
					if ( 'wpbk_category' === $query_variable || 'wpbk_tag' === $query_variable ) {
						$attr_value = get_the_terms( $wpbk_current_post_id, 'wpbk_book_' . $book_attr );
						if ( $attr_value && ! is_wp_error( $attr_value ) ) {
							$attr_value = array_column( $attr_value, 'name' );
							if ( ! empty( $attr_value ) ) {
								$attr_value = implode( ' , ', $attr_value );
							}
						} else {
							continue;
						}
					} else {
						$attr_value = $wpbk_db_io->get_wpbk_book_meta( $wpbk_current_post_id, $query_variable );
					}

					if ( empty( $attr_value ) ) {
						continue;
					}
					if ( 'wpbk_description' === $query_variable ) {
						$content .= "
							<tr>
								<td>
									<label for='" . esc_attr( $field_id ) . "'> " . esc_html( $label ) . " </label>
									<p class='wpbk-single-book-" . esc_attr( $book_attr ) . " id='" . esc_attr( $field_id ) . "'>" .
									wp_kses(
										$attr_value,
										array(
											'br'     => array(),
											'em'     => array(),
											'strong' => array(),
											'p'      => array(),
										)
									) . '
									</p>
								</td>
							</tr>
						';
					} elseif ( 'wpbk_price' === $query_variable ) {

						if ( empty( (float) $attr_value ) ) {
							continue;
						}
						$wpbk_display_price = $wpbk_db_io->wpbk_display_price_conversion( $attr_value );
						$content           .= "
							<tr>
								<td>
									<label for='" . esc_attr( $field_id ) . "'> " . esc_html( $label ) . " </label>
									<p class='wpbk-single-book-" . esc_attr( $book_attr ) . " id='" . esc_attr( $field_id ) . "'>" .
										esc_html( number_format( (float) $wpbk_display_price['price'], 2 ) . ' ' . $wpbk_display_price['unit'] ) . '
									</p>
								</td>
							</tr>
						';
					} else {
						$content .= "
							<tr>
								<td>
									<label for='" . esc_attr( $field_id ) . "'> " . esc_html( $label ) . " </label>
									<p class='wpbk-single-book-" . esc_attr( $book_attr ) . "' id='" . esc_attr( $field_id ) . "'>" . esc_html( $attr_value ) . '</p>
								</td>
							</tr>
						';
					}
				}
				unset( $wpbk_db_io );
				$content .= '</table> </div> </div>';
			}
		} catch ( Exception $e ) {
			return $content;
		}
		return $content;
	}

	/**
	 * Adds actions and filters for book settings and book content
	 *
	 * @return void
	 */
	public function wpbk_book_add_custom_query() {
		add_action( 'pre_get_posts', array( $this, 'wpbk_books_custom_query_init' ) );
		add_filter( 'the_content', array( $this, 'wpbk_filter_content_in_the_main_loop' ) );
		do_action( 'wpbk_forex_rate_update' );
	}
}
