<?php
/**
 * ExchangeHost API Forex Rate Update Operations
 *
 * @package wpbook
 */

/**
 * Updates API Currency forex rates
 */
class WPBk_Update_Currency_Forex_Rate {

	/**
	 * Updates API fx rates
	 * sets fx rates transients
	 *
	 * @param boolean $manual : update type.
	 * @param int     $transt_lifetime : response cache lifetime.
	 * @return void|Exception
	 */
	public function wpbk_forex_rate_update( $manual = false, $transt_lifetime = WEEK_IN_SECONDS ) {

		$manual          = rest_sanitize_boolean( $manual );
		$transt_lifetime = intval( $transt_lifetime );
		// api request endpoint.
		$req_url = 'https://api.exchangerate.host/latest';
		// decimal precision.
		$decimal_places = 5;

		foreach ( array_keys( WPBK_CURRENCY_OPTIONS ) as $base_currency ) {

			$transt_name = 'wpbk_api_' . strtolower( $base_currency ) . '_forex_rates';
			if ( ! get_transient( $transt_name ) || $manual ) {
				$api_data      = array();
				$api_call_url  = $req_url .
					'?base=' . $base_currency .
					'&symbols=' . implode( ',', array_keys( WPBK_CURRENCY_OPTIONS ) ) .
					'&places=' . $decimal_places;
				$response_json = wp_remote_get( $api_call_url );

				if ( false !== $response_json && ! is_wp_error( $response_json ) ) {
					try {
						$response         = json_decode( $response_json['body'] );
						$api_data['base'] = sanitize_text_field( $response->base );
						$api_data['date'] = sanitize_key( $response->date );
						foreach ( $response->rates as $currency => $currency_rate ) {
							$api_data['rates'][ $currency ] = floatval( $currency_rate );
						}

						if ( true === $response->success ) {
							set_transient( $transt_name, $api_data, $transt_lifetime );
						}
					} catch ( Exception $e ) {
						return $e;
					}
				}
			}
		}
	}

	/**
	 * Manual update currency forex rates
	 *
	 * @return void
	 */
	public function wpbk_forex_rate_manual_update() {

		if ( ! isset( $_REQUEST['nonce'] ) ) {
			die( 'Nonce value cannot be verified.' );
		}

		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'wpbk_update_book_price_or_currency_rates' ) ) {
			die( 'Nonce value cannot be verified.' );
		}
		$this->wpbk_forex_rate_update( true );
	}

	/**
	 * Actions to add forex rate update
	 *
	 * @return void
	 */
	public function wpbk_forex_rate_update_init() {
		add_action( 'wpbk_forex_rate_update', array( $this, 'wpbk_forex_rate_update' ) );
		add_action( 'wp_ajax_wpbk_forex_rate_manual_update', array( $this, 'wpbk_forex_rate_manual_update' ) );
	}
}
