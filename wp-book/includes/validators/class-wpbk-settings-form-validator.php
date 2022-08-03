<?php
/**
 * Book Admin Settings Validator
 *
 * @package wpbook
 */

/**
 * Book settings validator class
 */
class WPBk_Settings_Form_Validator {

	/**
	 * Books per page setting validator
	 *
	 * @param int $value : no. of books per page.
	 * @return int
	 */
	public function wpbk_books_per_page( $value ) {

		if ( ! 'int' === gettype( $value ) || empty( $value ) ) {
			return 10;
		}
		$value = (int) $value;
		return $value;
	}

	/**
	 * Book attributes to display settings validator
	 *
	 * @param array $value : array of book attributes.
	 * @return array
	 */
	public function wpbk_book_info_to_display( $value ) {

		if ( 'array' === gettype( $value ) && ! empty( $value ) ) {

			foreach ( $value as $key => $val ) {
				$val = sanitize_text_field( $val );
				if ( ! in_array( $key, array_keys( WPBK_BOOKINFO_DISPLAY_OPTIONS ), true ) || '1' !== $val ) {
					unset( $value[ $key ] );
				} else {
					$value[ $key ] = $val;
				}
			}
			if ( empty( $value ) ) {
				$value = get_option( 'wpbk_book_info_display' );
			}
			return $value;
		}
		return array();
	}

	/**
	 * Base Currency Settings Validator
	 *
	 * @param array $value : base currency units.
	 * @return array|string
	 */
	public function wpbk_base_currency_dropdown( $value ) {

		$value = sanitize_text_field( $value );
		if ( ! in_array( $value, array_keys( WPBK_CURRENCY_OPTIONS ), true ) ) {
			$value = get_option( 'wpbk_base_currency' );
		}
		return $value;
	}

	/**
	 * Display Currency Settings Validator
	 *
	 * @param array $value : display currency units.
	 * @return array|string
	 */
	public function wpbk_display_currency_dropdown( $value ) {

		$value = sanitize_text_field( $value );
		if ( ! in_array( $value, array_keys( WPBK_CURRENCY_OPTIONS ), true ) ) {
			$value = get_option( 'wpbk_display_book_currency_unit' );
		}
		return $value;
	}

	/**
	 * Display Currency Forex Rate Options Validator
	 *
	 * @param array $value : forex rate options.
	 * @return array|string
	 */
	public function wpbk_display_fx_rate_dropdown( $value ) {

		$value = sanitize_text_field( $value );
		if ( ! in_array( $value, array_keys( WPBK_FX_RATE_TYPES ), true ) ) {
			$value = get_option( 'wpbk_display_currency_fx_rate_type' );
		}
		return $value;
	}

	/**
	 * Forex Table Settings Validator
	 *
	 * @param array $value : forex rates.
	 * @return array|string
	 */
	public function wpbk_forex_table_validation( $value ) {
		$arr_keys = array(
			'INR_USD',
			'INR_EUR',
			'USD_INR',
			'USD_EUR',
			'EUR_INR',
			'EUR_USD',
		);
		$diff     = array_diff( $arr_keys, array_keys( $value ) );

		if ( empty( $diff ) ) {
			foreach ( $value as $key => $val ) {
				if ( ! empty( $val ) ) {
					$value[ $key ] = (float) $val;
				}
			}
		} else {
			$value = get_option( 'wpbk_forex_rate' );
		}
		return $value;
	}
}
