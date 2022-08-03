<?php
/**
 * Forex Rate Table Setting Template File
 *
 * @package wpbook
 */

$wpbk_forex_rate = get_option( 'wpbk_forex_rate' );
if ( empty( $wpbk_forex_rate ) ) {
	$wpbk_forex_rate = array();
}
$wpbk_api_inr_forex_rate = get_transient( 'wpbk_api_inr_forex_rates' );
$wpbk_api_usd_forex_rate = get_transient( 'wpbk_api_usd_forex_rates' );
$wpbk_api_eur_forex_rate = get_transient( 'wpbk_api_eur_forex_rates' );
?>

<table id="wpbk-forex-table" >
	<tr>
		<th> Source Currency </th>
		<th> Target Currency </th>
		<th> User Defined Currency Rate </th>
		<th> API Currency Rate &nbsp; <a href="#" title="refresh forex api rates" id="forex-rate-manual-update" name="forex-rate-manual-update"> &#9862; </a></th>
	</tr>
	<tr>
		<td>INR</td>
		<td>USD</td>
		<td><input name="wpbk_forex_rate[INR_USD]" id="wpbk_forex_rate[INR_USD]" 
			type="number" 
			step="any"
			value="<?php echo ( isset( $wpbk_forex_rate['INR_USD'] ) ? esc_attr( $wpbk_forex_rate['INR_USD'] ) : '' ); ?>">
		</td>
		<td class="wpbk-api-rates" ><?php echo ( isset( $wpbk_api_inr_forex_rate['rates']['USD'] ) ? esc_html( $wpbk_api_inr_forex_rate['rates']['USD'] ) : '' ); ?></td>
	</tr>
	<tr>
		<td>USD</td>
		<td>INR</td>
		<td><input name="wpbk_forex_rate[USD_INR]" id="wpbk_forex_rate[USD_INR]" 
			type="number" 
			step="any"
			value="<?php echo ( isset( $wpbk_forex_rate['USD_INR'] ) ? esc_attr( $wpbk_forex_rate['USD_INR'] ) : '' ); ?>">
		</td>
		<td class="wpbk-api-rates" ><?php echo ( isset( $wpbk_api_usd_forex_rate['rates']['INR'] ) ? esc_html( $wpbk_api_usd_forex_rate['rates']['INR'] ) : '' ); ?></td>
	</tr>
	<tr>
		<td>INR</td>
		<td>EUR</td>
		<td><input name="wpbk_forex_rate[INR_EUR]" id="wpbk_forex_rate[INR_EUR]" 
			type="number" 
			step="any"
			value="<?php echo ( isset( $wpbk_forex_rate['INR_EUR'] ) ? esc_attr( $wpbk_forex_rate['INR_EUR'] ) : '' ); ?>">
		</td>
		<td class="wpbk-api-rates" ><?php echo ( isset( $wpbk_api_inr_forex_rate['rates']['EUR'] ) ? esc_html( $wpbk_api_inr_forex_rate['rates']['EUR'] ) : '' ); ?></td>
	</tr>
	<tr>
		<td>EUR</td>
		<td>INR</td>
		<td><input name="wpbk_forex_rate[EUR_INR]" id="wpbk_forex_rate[EUR_INR]" 
			type="number" 
			step="any"
			value="<?php echo ( isset( $wpbk_forex_rate['EUR_INR'] ) ? esc_attr( $wpbk_forex_rate['EUR_INR'] ) : '' ); ?>">
		</td>
		<td class="wpbk-api-rates" ><?php echo ( isset( $wpbk_api_eur_forex_rate['rates']['INR'] ) ? esc_html( $wpbk_api_eur_forex_rate['rates']['INR'] ) : '' ); ?></td>
	</tr>
	<tr>
		<td>USD</td>
		<td>EUR</td>
		<td><input name="wpbk_forex_rate[USD_EUR]" id="wpbk_forex_rate[USD_EUR]" 
			type="number" 
			step="any"
			value="<?php echo ( isset( $wpbk_forex_rate['USD_EUR'] ) ? esc_attr( $wpbk_forex_rate['USD_EUR'] ) : '' ); ?>">
		</td>
		<td class="wpbk-api-rates" ><?php echo ( isset( $wpbk_api_usd_forex_rate['rates']['EUR'] ) ? esc_html( $wpbk_api_usd_forex_rate['rates']['EUR'] ) : '' ); ?></td>
	</tr>
	<tr>
		<td>EUR</td>
		<td>USD</td>
		<td><input name="wpbk_forex_rate[EUR_USD]" id="wpbk_forex_rate[EUR_USD]" 
			type="number" 
			step="any"
			value="<?php echo ( isset( $wpbk_forex_rate['EUR_USD'] ) ? esc_attr( $wpbk_forex_rate['EUR_USD'] ) : '' ); ?>">
		</td>
		<td class="wpbk-api-rates" ><?php echo ( isset( $wpbk_api_eur_forex_rate['rates']['USD'] ) ? esc_html( $wpbk_api_eur_forex_rate['rates']['USD'] ) : '' ); ?></td>
	</tr>
</table>

<p>
	<?php /* translators: 1: html break tag 2: currency unit 3: currency unit and html tag 4: numbers */ ?> 
	<?php printf( esc_html__( 'Currency Rate can be calculated as : %1$s Suppose conversion %2$s , If %3$s then currency rate for such conversion would be %4$s', 'wpbk' ), '</br>', 'INR->USD', '{ 75 INR = 1 USD } </br>', '[ 1/75 ] = 0.013333' ); ?>
</p>
