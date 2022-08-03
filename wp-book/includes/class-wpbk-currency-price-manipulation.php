<?php
/**
 * API currency rate update operations
 *
 * @package wpbook
 */

/**
 * Price manipulation on base price update
 */
class WPBk_Currency_Price_Manipulation {

	/**
	 * Converts book base price as per new currency
	 *
	 * @return void
	 */
	public function wpbk_base_currency_book_price_update() {

		if ( ! isset( $_REQUEST['nonce'] ) ) {
			die( esc_html__( 'Not Authorized', 'wpbk' ) );
		}

		// check for nonce.
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'wpbk_update_book_price_or_currency_rates' ) ) {
			die( esc_html__( 'Nonce value cannot be verified.', 'wpbk' ) );
		}

		// The $_REQUEST contains all the data sent via ajax.
		if ( isset( $_REQUEST ) &&
			( isset( $_REQUEST['fx_type'] ) && ! empty( $_REQUEST['fx_type'] ) ) &&
			( isset( $_REQUEST['target_currency'] ) && ! empty( $_REQUEST['target_currency'] ) ) ) {

			$fx_type         = sanitize_key( $_REQUEST['fx_type'] );
			$target_currency = sanitize_text_field( $_REQUEST['target_currency'] );

			if ( ! in_array( $fx_type, array_keys( WPBK_FX_RATE_TYPES ), true ) ||
				! in_array( $target_currency, array_keys( WPBK_CURRENCY_OPTIONS ), true ) ) {
				esc_html_e( 'Forex Type or Target Currency is not valid', 'wpbk' );
				die();
			}
			try {
				if ( class_exists( 'WPBk_DB_IO' ) ) {
					try {
						$wpbk_db_io = new WPBk_DB_IO();
						// call to update book prices.
						$result = $wpbk_db_io->wpbk_update_books_prices( $fx_type, $target_currency );
						if ( $result ) {
							/* translators: %s: html break tag */
							printf( esc_html__( 'Request Successfully Executed... %s', 'wpbk' ), '</br>' );
							esc_html_e( 'Save changes now to avoid any error or malfunction.', 'wpbk' );
						} else {
							/* translators: %s: html break tag */
							printf( esc_html__( 'Request Failure...%s', 'wpbk' ), '</br>' );
								esc_html_e( 'Check the currency rates carefully and try again.', 'wpbk' );
						}
						unset( $wpbk_db_io );
					} catch ( Exception $e ) {
						esc_html_e( 'Error Processing Request...', 'wpbk' );
					}
				} else {
					esc_html_e( 'Error Processing Request...', 'wpbk' );
				}
			} catch ( Exception $e ) {
				esc_html_e( 'Error Processing Request...', 'wpbk' );
			}
		} else {
			esc_html_e( 'Error Fetching Data, Make Sure You Follow All The Steps ...', 'wpbk' );
		}
		die();
	}
}
