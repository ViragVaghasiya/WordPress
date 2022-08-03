<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<?php
/**
 * Book Information Form Template File
 *
 * @package wpbook
 */

try {
	$wpbk_author_name          = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_author_name', true );
	$wpbk_published_year       = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_published_year', true );
	$wpbk_price                = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_price', true );
	$wpbk_publisher            = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_publisher', true );
	$wpbk_edition              = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_edition', true );
	$wpbk_url                  = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_url', true );
	$wpbk_book_pages           = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_book_pages', true );
	$wpbk_rating               = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_rating', true );
	$wpbk_language             = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_language', true );
	$wpbk_description          = $wpbk_db_io->get_wpbk_book_meta( $post->ID, 'wpbk_description', true );
	$wpbk_currency_unit        = get_option( 'wpbk_base_currency' );
	$wpbk_currency_unit_symbol = (
		( 'USD' === $wpbk_currency_unit ) ? '$' :
		( ( 'INR' === $wpbk_currency_unit ) ? '&#8377' :
		( ( 'EUR' === $wpbk_currency_unit ) ? '&euro' : '' ) )
	);
} catch ( Exception $e ) {
	return $e;
}
?>

<body>
	<div class="wpbk-box">
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" id="wpbk-thumbnail-label" for="wpbk-thumbnail-url"><?php esc_html_e( 'Thumbnail URL :  ', 'wpbk' ); ?></label>
			<a id="wpbk-thumbnail-url" href=""></a>
		</p>
		</br>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" id="wpbk-suggest-category-label" for="wpbk-suggest-category"><?php esc_html_e( 'Suggested Category :  ', 'wpbk' ); ?></label>
			<span id="wpbk-suggest-category" href=""></span>
		</p>
		<hr id="wpbk-line" >
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_author_name"><?php esc_html_e( 'Author Name', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_author_name"
				type="text"
				name="wpbk_author_name"
				value="<?php echo esc_attr( $wpbk_author_name ); ?>">
			<span class="wpbk-book-info-form-validation" id="wpbk_author_name_span" >123</span>
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_published_year"><?php esc_html_e( 'Publish Year', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_published_year"
				type="number"
				min="1600"
				max=<?php echo esc_attr( gmdate( 'Y' ) ); ?>
				name="wpbk_published_year"
				value="<?php echo esc_attr( $wpbk_published_year ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" 
				for="wpbk_price">
				<?php esc_html_e( 'Price', 'wpbk' ); ?> ( <?php echo sanitize_text_field( $wpbk_currency_unit_symbol ); // phpcs:ignore ?> ) 
				</label>
			<input type="hidden" name="wpbk_currency_unit" value='<?php echo esc_textarea( $wpbk_currency_unit ); ?>' > 
			<input class="wpbk-book-info-form-input" id="wpbk_price"
				type="number"
				name="wpbk_price"
				placeholder="<?php echo sanitize_text_field( $wpbk_currency_unit_symbol ); // phpcs:ignore?>"
				value="<?php echo esc_attr( $wpbk_price ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_publisher"><?php esc_html_e( 'Publisher', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_publisher"
				type="text"
				name="wpbk_publisher"
				value="<?php echo esc_attr( $wpbk_publisher ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_edition"><?php esc_html_e( 'Edition', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_edition"
				type="text"
				name="wpbk_edition"
				value="<?php echo esc_attr( $wpbk_edition ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_url"><?php echo esc_html_e( 'URL', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_url"
				type="url"
				name="wpbk_url"
				value="<?php echo esc_url( $wpbk_url ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_book_pages"><?php esc_html_e( 'No. of Pages', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_book_pages"
				type="number"
				name="wpbk_book_pages"
				value="<?php echo esc_attr( $wpbk_book_pages ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_rating"><?php esc_html_e( 'Rating', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_rating"
				type="number"
				name="wpbk_rating"
				step="0.01"
				value="<?php echo esc_attr( $wpbk_rating ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_language"><?php esc_html_e( 'Language', 'wpbk' ); ?></label>
			<input class="wpbk-book-info-form-input" id="wpbk_language"
				type="text"
				name="wpbk_language"
				value="<?php echo esc_attr( $wpbk_language ); ?>">
		</p>
		<p class="meta-options wpbk-field">
			<label class="wpbk-book-info-form-label" for="wpbk_description"><?php esc_html_e( 'Description', 'wpbk' ); ?></label>
			<textarea class="wpbk-book-info-form-input" id="wpbk_description" 
				name="wpbk_description" 
				placeholder="Write your own description of the book..." 
				rows="4" 
				cols="50">
				<?php
				if ( ! empty( $wpbk_description ) ) {
					$allowed_tags = array( '<br>', '</br>', '<strong>', '</strong>', '<em>', '</em>', '<p>', '</p>' );
					echo wp_kses(
						$wpbk_description,
						array(
							'br'     => array(),
							'em'     => array(),
							'strong' => array(),
							'p'      => array(),
						)
					);
				}
				?>
				</textarea>
		</p>
		<?php wp_nonce_field( 'wp_book_form_fields_save_check', 'wpbk_save_book_info_nonce' ); ?>

	</div>
</body>

</html>
