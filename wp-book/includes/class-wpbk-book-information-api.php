<?php
/**
 * Handles Google Book API Operations
 *
 * @package wpbook
 */

/**
 * Provides Book Information using google books api
 */
class WPBk_Book_Information_API {

	/**
	 * Fetches the book information from api
	 *
	 * @return void
	 */
	public function wpbk_fetch_book_information() {

		if ( ! isset( $_REQUEST['nonce'] ) || ! isset( $_REQUEST['search_term'] ) ) {
			die( esc_html__( 'Parameters are not set, Please try again....', 'wpbk' ) );
		}

		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'wpbk_bookinfo_api_nonce' ) ) {
			die( esc_html__( 'Nonce value cannot be verified.', 'wpbk' ) );
		}

		$book = sanitize_title( wp_unslash( $_REQUEST['search_term'] ) );
		if ( empty( $book ) ) {
			die( esc_html__( 'Please Input A Book Name...', 'wpbk' ) );
		}

		$book     = str_replace( ' ', '-', $book );
		$book_url = '';
		if ( isset( $_REQUEST['search_type'] ) ) {
			if ( 'specific' === $_REQUEST['search_type'] ) {
				$search_fields = '?fields=id,volumeInfo(title,authors,publisher,publishedDate,description,pageCount,categories,averageRating,language,previewLink,imageLinks(thumbnail)),searchInfo(textSnippet)';
				$book_url      = ' https://www.googleapis.com/books/v1/volumes/' . $book . $search_fields;
			} elseif ( 'generic' === $_REQUEST['search_type'] ) {
				$search_fields = '&fields=items(id,volumeInfo(title))';
				$book_url      = 'https://www.googleapis.com/books/v1/volumes?q=' . $book . $search_fields;
			}
		}

		if ( empty( $book_url ) ) {
			echo '';
			die();
		}

		$response = wp_remote_get( $book_url );

		if ( false !== $response && ! is_wp_error( $response ) ) {
			try {
				if ( isset( $response['response']['code'] ) && 200 === $response['response']['code'] ) {
					if ( isset( $response['body'] ) ) {
						$response = json_decode( $response['body'] );
						if ( 'generic' === $_REQUEST['search_type'] ) {
							if ( isset( $response->items ) ) {
								$response = $response->items;
							}
						}
						echo wp_json_encode( $response );
					} else {
						echo '';
					}
				} else {
					echo '';
				}
				die();
			} catch ( Exception $e ) {
				echo '';
				die();
			}
		} else {
			echo '';
		}
		die();
	}

	/**
	 * Action to fetch book information
	 *
	 * @return void
	 */
	public function wpbk_book_information_api_init() {
		add_action( 'wp_ajax_wpbk_book_information_api', array( $this, 'wpbk_fetch_book_information' ) );
	}
}
