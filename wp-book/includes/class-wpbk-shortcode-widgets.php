<?php
/**
 * Book Shortcode
 *
 * @package wpbook
 */

/**
 * Defines a shortcode named book
 */
class WPBk_Shortcode_Widgets {

	/**
	 * Retrieves books of specified attributes
	 *
	 * @param array $atts : shortcode attributes.
	 * @return array
	 */
	public function wpbk_book_shortcode( $atts ) {

		$refined_atts = array();
		if ( ! empty( $atts ) && 'array' === gettype( $atts ) ) {
			$atts = array_filter( $atts );

			foreach ( $atts as $att => $value ) {
				$att           = sanitize_key( $att );
				$value         = sanitize_text_field( $value );
				$value         = trim( $value, ' ,' );
				$str_elements  = explode( ',', $value );
				$refined_value = '';
				foreach ( $str_elements as $element ) {
					$refined_value .= trim( $element, "' ," ) . ',';
				}
				$refined_value        = trim( $refined_value, ' ,' );
				$refined_atts[ $att ] = $refined_value;
			}
			$refined_atts = array_filter( $refined_atts );
		}

		if ( class_exists( 'WPBk_DB_IO' ) && ! empty( $refined_atts ) && 'array' === gettype( $refined_atts ) ) {
			try {
				$display_attr = get_option( 'wpbk_book_info_display' );
				if ( empty( $display_attr ) || 'array' !== gettype( $display_attr ) ) {
					$display_attr = false;
				} else {
					$display_attr = array_intersect( array_keys( $display_attr ), array_keys( WPBK_BOOKINFO_DISPLAY_OPTIONS ) );
					if ( empty( $display_attr ) ) {
						$display_attr = false;
					}
				}

				$wpbk_db = new WPBk_DB_IO();
				$result  = $wpbk_db->wpbk_search_books( $refined_atts );

				$wpbk_books = "<div class='books-shrtcd-result'>";
				if ( $result->have_posts() ) {
					while ( $result->have_posts() ) {
						$result->the_post();
						$wpbk_result_post_id = get_the_ID();

						$wpbk_books .= "
							<div class='shrtcd-book' >
								<table>
									<tr>
										<section class='shrtcd-book-title'> <h2>" . esc_html( get_the_title( $wpbk_result_post_id ) ) . "</h2> </section>
									</tr>
									</br>
									<tr>
										<td>
											<p class='shrtcd-book-post-content' id='shrtcd-book-content'>" . sanitize_post( get_the_content( $wpbk_result_post_id ) ) . '
											</p>
										</td>
									</tr>
						';

						if ( $display_attr ) {
							foreach ( $display_attr as $book_attr ) {
								$field_id = 'shrtcd-' . str_replace( '_', '-', $book_attr );
								$label    = ucwords( str_replace( '_', ' ', $book_attr ) );

								$query_variable = 'wpbk_' . $book_attr;
								$attr_value     = null;
								if ( 'wpbk_category' === $query_variable || 'wpbk_tag' === $query_variable ) {
									$attr_value = get_the_terms( $wpbk_result_post_id, 'wpbk_book_' . $book_attr );
									if ( $attr_value && ! is_wp_error( $attr_value ) ) {
										$attr_value = array_column( $attr_value, 'name' );
										if ( ! empty( $attr_value ) ) {
											$attr_value = implode( ' , ', $attr_value );
										}
									} else {
										continue;
									}
								} else {
									$attr_value = $wpbk_db->get_wpbk_book_meta( $wpbk_result_post_id, $query_variable );
								}

								if ( empty( $attr_value ) ) {
									continue;
								}
								if ( 'wpbk_description' === $query_variable && 'NA' !== $attr_value ) {
									$wpbk_books .= "
										<tr>
											<td>
												<label for='" . esc_attr( $field_id ) . "'> " . esc_html( $label ) . " </label>
												<p class='shrtcd-book-" . esc_attr( $book_attr ) . " id='" . esc_attr( $field_id ) . "'>" .
													wp_kses(
														$attr_value,
														array(
															'br' => array(),
															'em' => array(),
															'strong' => array(),
															'p' => array(),
														)
													) . '
												</p>
											</td>
										</tr>
									';
								} elseif ( 'wpbk_price' === $query_variable && 'NA' !== $attr_value ) {
									$display_price = $wpbk_db->wpbk_display_price_conversion( $attr_value );
									$wpbk_books   .= "
										<tr>
											<td>
												<label for='" . esc_attr( $field_id ) . "'> " . esc_html( $label ) . " </label>
												<p class='shrtcd-book-" . esc_attr( $book_attr ) . " id='" . esc_attr( $field_id ) . "'>" .
													esc_html( number_format( (float) $display_price['price'], 2 ) . ' ' . $display_price['unit'] ) . '
												</p>
											</td>
										</tr>
									';
								} else {
									$wpbk_books .= "
										<tr>
											<td>
												<label for='" . esc_attr( $field_id ) . "'> " . esc_html( $label ) . " </label>
												<p class='shrtcd-book-" . esc_attr( $book_attr ) . " id='" . esc_attr( $field_id ) . "'>" .
													esc_html( $attr_value ) . '
												</p>
											</td>
										</tr>
									';
								}
							}
						}
						$wpbk_books .= '</table> </div> <hr>';
					}
				}
				unset( $wpbk_db );
				$wpbk_books .= '</div>';
				return $wpbk_books;

			} catch ( Exception $e ) {
				return $e;
			}
		}
	}

	/**
	 * Adds shortcode book
	 *
	 * @return void
	 */
	public function wpbk_add_book_shortcode() {
		add_shortcode( 'book', array( $this, 'wpbk_book_shortcode' ) );
	}
}
