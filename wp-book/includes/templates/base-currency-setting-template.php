<?php
/**
 * Base Currency settings template file
 *
 * @package wpbook
 */

$wpbk_base_currency = get_option( 'wpbk_base_currency' );
?>

<select name='wpbk_base_currency' id='wpbk-base-currency'
	onchange="wpbkDisplayRecalculate( '<?php echo esc_attr( $wpbk_base_currency ); ?>' )">
	<?php
	foreach ( WPBK_CURRENCY_OPTIONS as $unit => $unit_label ) {
		?>
			<option <?php selected( 1, ( ( $wpbk_base_currency === $unit ) ? 1 : 0 ), true ); ?>
				value='<?php echo esc_attr( $unit ); ?>'> <?php echo esc_html( $unit_label ); ?> </option>
		<?php
	}
	?>
</select>
<p>
	<?php esc_html_e( 'This currency unit will be used to store book price in database and to calculate display price', 'wpbk' ); ?>
</p>
</br>

<input type='checkbox' onchange="wpbkSubmitLink()" name='wpbk_require_price_recalculate' 
	id='wpbk-require-price-recalculate'/>
<label for='wpbk-require-price-recalculate' id="price-recalculate-label">
	<strong><?php esc_html_e( 'Recalculate saved book Prices :: ', 'wpbk' ); ?> </strong> 
	<?php echo esc_html( $wpbk_base_currency . ' -> ' ); ?>
</label>

<p id="price-recalculate-description1"> 
	<?php
	printf(
		/* translators: 1: html break tag 2: html break tag 3: html break tag */
		esc_html__(
			'It may take a while depending on the no. of books. %1$s 
			Or leave this if you want to update it manually. %2$s %3$s Notice : You can only try to recalculate once, 
			If anything goes wrong you can try again by refreshing the page.',
			'wpbk'
		),
		'</br>',
		'</br>',
		'</br>'
	);
	?>
</p>

<select name="forex_rate_type" id="forex-rate-type">
	<option><?php esc_html_e( 'Select a Forex Rate Type', 'wpbk' ); ?></option>
	<?php
	foreach ( WPBK_FX_RATE_TYPES as $fx_type => $fx_label ) {
		?>
			<option value="<?php echo esc_attr( $fx_type ); ?>"><?php echo esc_html( $fx_label ); ?></option>
		<?php
	}
	?>
</select>

<a href="#" name="wpbk_recalc_button" id="wpbk-recalc-button" > <?php esc_html_e( 'Recalculate', 'wpbk' ); ?></a>
<img name="price_update_loading" id="price-update-loading" 
	height="24"
	width="24"
	src="<?php echo esc_url( WPBK_ASSETS_URL . '/media/wpbk-loader.gif' ); ?>" 
	alt="processing...">

<p name="price_update_result" id="price-update-result"></p>

<p id="price-recalculate-warning" >
	<?php
	printf(
		/* translators: 1: html break tag 2: html break tag */
		esc_html__(
			'%1$s  !! Prices will be updated based on the current forex rate saved in the database !! 
			%2$s !! So save the settings first and then recalculate if you wish to update forex rates 
			from the current save action. !!',
			'wpbk'
		),
		'</br>',
		'</br>'
	);
	?>
</p>
<?php
