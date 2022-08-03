<?php
/**
 * Handles all database related operations
 *
 * @package wpbook
 */

// denies direct access.
if ( ! defined( 'WPINC' ) ) {
	die( 'No direct access.' );
}

/**
 * Handles all database realted functions
 */
class WPBk_DB_IO {

	/**
	 * Installs bookmeta schema
	 *
	 * @return void
	 */
	public static function wpbk_install() {
		try {
			global $wpdb;
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			// wp_wpbk_bookmeta schema.
			$wpbk_bookmeta_schema = "CREATE TABLE {$wpdb->prefix}wpbk_bookmeta (
				meta_id bigint(20) NOT NULL AUTO_INCREMENT,
				wpbk_book_id bigint(20) NOT NULL DEFAULT '0',
				meta_key varchar(255) DEFAULT NULL,
				meta_value longtext,
				PRIMARY KEY meta_id (meta_id),
				KEY wpbk_book_id (wpbk_book_id),
				KEY meta_key (meta_key)
				) CHARACTER SET utf8 COLLATE utf8_general_ci;";

			dbDelta( $wpbk_bookmeta_schema );
		} catch ( Exception $e ) {
			wp_die( esc_html__( 'Error Creating DB...', 'wpbk' ) );
		}
	}

	/**
	 * Gets bookmeta metadata
	 *
	 * @param int     $id : id of the post.
	 * @param string  $meta_key : meta key.
	 * @param boolean $single : first value of the meta key.
	 * @throws Exception : general exception.
	 * @return array|string|int
	 */
	public function get_wpbk_book_meta( $id, $meta_key, $single = true ) {
		try {
			return get_metadata( 'wpbk_book', $id, $meta_key, $single );
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Updates bookmeta metadata
	 *
	 * @param int    $id : id of the post.
	 * @param string $meta_key : meta key.
	 * @param string $value : value of the meta key.
	 * @throws Exception : general exception.
	 * @return array|string|int
	 */
	public function update_wpbk_book_meta( $id, $meta_key, $value = '' ) {
		try {
			return update_metadata( 'wpbk_book', $id, $meta_key, $value );
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Adds bookmeta metadata
	 *
	 * @param int    $id : id of the post.
	 * @param string $meta_key : meta key.
	 * @param string $value : value of the meta key.
	 * @throws Exception : general exception.
	 * @return array|string|int
	 */
	public function add_wpbk_book_meta( $id, $meta_key, $value = '' ) {
		try {
			return add_metadata( 'wpbk_book', $id, $meta_key, $value );
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Deletes bookmeta metadata
	 *
	 * @param int   $id : id of the post.
	 * @param array $meta_keys : meta keys array.
	 * @throws Exception : general exception.
	 * @return boolean
	 */
	public function delete_wpbk_book_meta( $id, $meta_keys = array() ) {
		try {
			$wpbk_result = true;
			if ( is_array( $meta_keys ) && ! empty( $meta_keys ) ) {
				foreach ( $meta_keys as $key ) {
					$result = delete_metadata( 'wpbk_book', $id, $key );
					if ( false === $result ) {
						$wpbk_result = false;
					}
				}
			}
			return $wpbk_result;
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Saves bookmeta form fields
	 *
	 * @param integer $post_id : id of the post.
	 * @param array   $form_fields : bookmeta fields.
	 * @throws Exception : general exception.
	 * @return void
	 */
	public function wpbk_save_book_form( int $post_id, array $form_fields ) {
		try {
			if ( ! empty( $form_fields ) && 'array' === gettype( $form_fields ) ) {
				foreach ( $form_fields as $field_key => $field_value ) {
					$this->update_wpbk_book_meta( $post_id, $field_key, $field_value );
				}
			}
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Retrives books with criteria
	 *
	 * @param int    $limit : result limit.
	 * @param string $required_fields : fields can be all or ids.
	 * @param array  $book_status : post status publish , draft.
	 * @throws Exception : general exception.
	 * @return array|boolean|string
	 */
	public function wpbk_get_books(
		$limit = -1,
		string $required_fields = 'all',
		array $book_status = array( 'publish' )
	) {
		try {
			if ( empty( $limit ) ||
				empty( $book_status ) || ( gettype( $book_status ) !== 'array' ) ||
				empty( $required_fields ) || ( gettype( $required_fields ) !== 'string' ) ) {
				return false;
			}

			$limit = ( 'int' === gettype( $limit ) ) ? $limit : -1;
			if ( empty( $limit ) ) {
				return false;
			}

			$posts_data      = '';
			$required_fields = ( 'ids' === $required_fields || 'all' === $required_fields ) ? $required_fields : false;

			if ( empty( $required_fields ) ) {
				return false;
			}

			$posts_data = get_posts(
				array(
					'fields'      => $required_fields,
					'post_status' => $book_status,
					'numberposts' => $limit,
					'post_type'   => 'wpbk_book',
				)
			);
			wp_reset_postdata();
			return $posts_data;
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Converts book prices as per new currency
	 *
	 * @param string $fx_type : forex rate type.
	 * @param string $target_currency : new currency unit.
	 * @throws Exception : general exception.
	 * @return boolean
	 */
	public function wpbk_update_books_prices( $fx_type, $target_currency ) {

		try {
			// current currency unit.
			$base_currency = get_option( 'wpbk_base_currency' );

			if ( ! empty( $base_currency ) && ! empty( $fx_type ) && ! empty( $target_currency ) ) {

				$currency_rate = null;

				if ( 'user_defined' === $fx_type ) {
					$currency_rates = get_option( 'wpbk_forex_rate' );
					if ( isset( $currency_rates[ $base_currency . '_' . $target_currency ] ) ) {
						$currency_rate = $currency_rates[ $base_currency . '_' . $target_currency ];
					} else {
						return false;
					}
				} elseif ( 'api_managed' === $fx_type ) {
					$api_fx_rates = get_transient( 'wpbk_api_' . strtolower( $base_currency ) . '_forex_rates' );
					if ( isset( $api_fx_rates['rates'][ $target_currency ] ) ) {
						$currency_rate = $api_fx_rates['rates'][ $target_currency ];
					} else {
						return false;
					}
				} else {
					return false;
				}
				// gets all book ids.
				$books_ids = $this->wpbk_get_books( 'all', 'ids', array( 'publish', 'draft' ) );
				foreach ( $books_ids as $book_id ) {
					$old_price = $this->get_wpbk_book_meta( $book_id, 'wpbk_price' );
					$new_price = ( (float) $old_price ) * ( (float) $currency_rate );
					$this->update_wpbk_book_meta( $book_id, 'wpbk_price', number_format( $new_price, 2 ) );
					$this->update_wpbk_book_meta( $book_id, 'wpbk_currency_unit', $target_currency );
				}
				return true;
			}
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}

	}

	/**
	 * Gets top categories on basis of post count
	 *
	 * @param array $args : arguments array.
	 * @throws Exception : general exception.
	 * @return array
	 */
	public function wpbk_top_categories_by_posts( $args ) {
		try {
			return get_categories( $args );
		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Checks if a string is comma separated
	 *
	 * @param string $book_attr : book attrbiute.
	 * @throws Exception : general exception.
	 * @return int|boolean
	 */
	private function is_multivalue( $book_attr ) {
		return strpos( $book_attr, ',' );
	}

	/**
	 * `posts_join` filter callback function
	 *
	 * @param string   $join  The JOIN clause of the query.
	 * @param WP_Query $wp_query The WP_Query instance (passed by reference).
	 *
	 * @return string
	 */
	public function wpbk_bookmeta_join( $join, $wp_query ) {
		global $wpdb;
		$join .= "
			LEFT JOIN {$wpdb->prefix}wpbk_bookmeta as wpbk_bookmeta on wpbk_bookmeta.wpbk_book_id = {$wpdb->posts}.ID
			LEFT JOIN {$wpdb->prefix}wpbk_bookmeta as wpbk_bookmeta2 on wpbk_bookmeta2.wpbk_book_id = {$wpdb->posts}.ID
			LEFT JOIN {$wpdb->prefix}wpbk_bookmeta as wpbk_bookmeta3 on wpbk_bookmeta3.wpbk_book_id = {$wpdb->posts}.ID
		";
		return $join;
	}

	/**
	 * `posts_where` filter callback function
	 *
	 * @param string   $where  The WHERE clause of the query.
	 * @param WP_Query $wp_query The WP_Query instance (passed by reference).
	 * @return string
	 */
	public function wpbk_bookmeta_where_condition( $where, $wp_query ) {
		if ( $wp_query->get( 'wpbk_bookmeta_custom_where_clause' ) !== '' ) {
			$where .= ' AND ' . $wp_query->get( 'wpbk_bookmeta_custom_where_clause' );
		}
		return $where;
	}

	/**
	 * Seprates comma separated values into an array
	 *
	 * @param string $book_attr : book attribute.
	 * @return array
	 */
	private function wpbk_process_comma_separated_values( $book_attr ) {
		$values = explode( ',', $book_attr );
		return array(
			'count'  => count( $values ),
			'values' => $values,
		);
	}

	/**
	 * Adds `post_join` filter
	 *
	 * @return void
	 */
	public function wpbk_add_bookmeta_join() {
		add_filter( 'posts_join', array( $this, 'wpbk_bookmeta_join' ), 10, 2 );
	}

	/**
	 * Adds `DISTINCT` attribute to query
	 *
	 * @return string
	 */
	public function search_distinct() {
		return 'DISTINCT';
	}

	/**
	 * Searches the books
	 *
	 * @param array $args : arguments array.
	 * @throws Exception : general exception.
	 * @return object|boolean|null
	 */
	public function wpbk_search_books( $args = array() ) {

		try {
			$search_query_args        = null;
			$bookmeta_where_condition = null;

			foreach ( $args as $arg => $value ) {

				if ( 'id' === $arg ) {

					$search_query_args['post__in'] = explode( ',', $value );

				} elseif ( 'author_name' === $arg ) {

					if ( $this->is_multivalue( $value ) !== false ) {
						$processed_value = $this->wpbk_process_comma_separated_values( $value );
						$values          = $processed_value['values'];
						$where_condition = '';
						while ( $processed_value['count'] > 0 ) {
							$where_condition .= " wpbk_bookmeta.meta_value LIKE '%" . $values[ $processed_value['count'] - 1 ] . "%' OR";
							$processed_value['count']--;
						}
						$bookmeta_where_condition .= 'AND ( wpbk_bookmeta.meta_key = "wpbk_author_name" AND (' . trim( $where_condition, 'OR' ) . ')) ';
					} else {
						$bookmeta_where_condition .= 'AND ( wpbk_bookmeta.meta_key = "wpbk_author_name" AND ( wpbk_bookmeta.meta_value LIKE "%' . $value . '%" )) ';
					}
				} elseif ( 'year' === $arg ) {

					if ( $this->is_multivalue( $value ) !== false ) {
						$processed_value = $this->wpbk_process_comma_separated_values( $value );
						$values          = $processed_value['values'];
						$where_condition = '';
						while ( $processed_value['count'] > 0 ) {
							$where_condition .= $values[ $processed_value['count'] - 1 ] . ',';
							$processed_value['count']--;
						}
						$bookmeta_where_condition .= 'AND ( wpbk_bookmeta2.meta_key = "wpbk_published_year" AND ( wpbk_bookmeta2.meta_value IN (' . trim( $where_condition, ',' ) . '))) ';
					} else {
						$bookmeta_where_condition .= 'AND ( wpbk_bookmeta2.meta_key = "wpbk_published_year" AND ( wpbk_bookmeta2.meta_value =' . $value . ' ) ) ';
					}
				} elseif ( 'publisher' === $arg ) {

					if ( $this->is_multivalue( $value ) !== false ) {
						$processed_value = $this->wpbk_process_comma_separated_values( $value );
						$values          = $processed_value['values'];
						$where_condition = '';
						while ( $processed_value['count'] > 0 ) {
							$where_condition .= " wpbk_bookmeta3.meta_value LIKE '%" . $values[ $processed_value['count'] - 1 ] . "%' OR";
							$processed_value['count']--;
						}
						$bookmeta_where_condition .= 'AND ( wpbk_bookmeta3.meta_key = "wpbk_publisher" AND (' . trim( $where_condition, 'OR' ) . ')) ';
					} else {
						$bookmeta_where_condition .= 'AND ( wpbk_bookmeta3.meta_key = "wpbk_publisher" AND ( wpbk_bookmeta3.meta_value LIKE "%' . $value . '%")) ';
					}
				} elseif ( 'category' === $arg ) {

					$search_query_args['tax_query']['relation'] = 'AND';
					$search_query_args['tax_query'][]           = array(
						'taxonomy' => 'wpbk_book_category',
						'field'    => 'name',
						'terms'    => $this->wpbk_process_comma_separated_values( $value )['values'],
					);

				} elseif ( 'tag' === $arg ) {

					$search_query_args['tax_query']['relation'] = 'AND';
					$search_query_args['tax_query'][]           = array(
						'taxonomy' => 'wpbk_book_tag',
						'field'    => 'name',
						'terms'    => $this->wpbk_process_comma_separated_values( $value )['values'],
					);
				}
			}
			if ( ! empty( $bookmeta_where_condition ) ) {
				$bookmeta_where_condition                               = '(' . trim( $bookmeta_where_condition, 'AND' ) . ')';
				$search_query_args['wpbk_bookmeta_custom_where_clause'] = $bookmeta_where_condition;
				$search_query_args['post_type']                         = 'wpbk_book';
				$search_query_args['orderby']                           = 'ID';

				add_filter( 'posts_join', array( $this, 'wpbk_bookmeta_join' ), 10, 2 );
				add_filter( 'posts_distinct', array( $this, 'search_distinct' ) );
				add_filter( 'posts_where', array( $this, 'wpbk_bookmeta_where_condition' ), 10, 2 );
			}

			$query = new WP_Query(
				$search_query_args
			);

			wp_reset_postdata();
			return $query;

		} catch ( Exception $e ) {
			throw new Exception( $e );
		}
	}

	/**
	 * Currency conversion operation as per display currency
	 *
	 * @param float|int|string $current_price : book's current price.
	 * @return array
	 */
	public function wpbk_display_price_conversion( $current_price ) {

		$display_currency_unit = get_option( 'wpbk_display_book_currency_unit' );
		$base_currency_unit    = get_option( 'wpbk_base_currency' );

		if ( $display_currency_unit === $base_currency_unit ) {
			return array(
				'price' => (float) $current_price,
				'unit'  => $base_currency_unit,
			);
		}
		$display_forex_rate_type = get_option( 'wpbk_display_currency_fx_rate_type' );
		$cnvrsn_rate             = null;
		if ( 'user_defined' === $display_forex_rate_type ) {
			$currency_rates = get_option( 'wpbk_forex_rate' );
			if ( ! empty( $currency_rates ) ) {
				$cnvrsn_rate = (float) $currency_rates[ $base_currency_unit . '_' . $display_currency_unit ];
			}
		} elseif ( 'api_managed' === $display_forex_rate_type ) {
			$base_currency  = strtolower( $base_currency_unit );
			$currency_rates = get_transient( 'wpbk_api_' . $base_currency . '_forex_rates' );
			if ( ! empty( $currency_rates ) ) {
				$cnvrsn_rate = (float) $currency_rates['rates'][ $display_currency_unit ];
			}
		}
		if ( ! $cnvrsn_rate || ! is_numeric( $cnvrsn_rate ) ) {
			return array(
				'price' => (float) $current_price,
				'unit'  => $base_currency_unit,
			);
		}
		return array(
			'price' => (float) $current_price * (float) $cnvrsn_rate,
			'unit'  => $display_currency_unit,
		);
	}
}
