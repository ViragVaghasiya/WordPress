<?php
/**
 * Book Information to Display Setting Template File
 *
 * @package wpbook
 */

$wpbk_display_options = get_option( 'wpbk_book_info_display' );
if ( empty( $wpbk_display_options ) ) {
	$wpbk_display_options = array();
}

echo '</br>';
foreach ( WPBK_BOOKINFO_DISPLAY_OPTIONS as $display_option => $display_option_label ) {
		$option_id      = str_replace( '_', '-', $display_option );
		$display_option = esc_attr( $display_option );
	?>
	<dt class='book-info-setting-checkbox'>
		<input type='checkbox' name='wpbk_book_info_display[<?php echo esc_attr( $display_option ); ?>]' 
			id='wpbk-bkinfo-<?php echo esc_attr( $option_id ); ?>' 
			value='1'
			<?php
			checked(
				'1',
				( array_key_exists( $display_option, $wpbk_display_options ) ? $wpbk_display_options[ $display_option ] : 0 ),
				true
			);
			?>
			/> 
		<label for='wpbk-bkinfo-<?php echo esc_attr( $option_id ); ?>'><?php echo esc_html( $display_option_label ); ?></label>
	</dt>
	<?php
}
?>
