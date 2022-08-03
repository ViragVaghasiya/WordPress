<?php
/**
 * Book Autofill Metabox Template File
 *
 * @package wpbook
 */

?>

<div id="search-book-group" >
	<p  class="meta-options wpbk-field">
		<label class="wpbk-book-info-form-label" for="bookinfo-autofill"><?php esc_html_e( 'Autofill the Book Information', 'wpbk' ); ?></label>   
		&nbsp; 
		<input class="wpbk-book-info-form-input" id="bookinfo-autofill" name="bookinfo_autofill" type="checkbox" >
	</p>
	</br>
	<p class="meta-options  wpbk-field">
		<input id="search-book"
			type="text"
			name="search_book"
			placeholder="Search Book"
			value="">
		</br>
		<button id="search-button" name="search_button"  > <?php esc_html_e( 'Search', 'wpbk' ); ?> </button>
		<img name="book_search_loading" id="book-search-loading" 
			height="24"
			width="24"
			src="<?php echo esc_url( WPBK_ASSETS_URL . '/media/wpbk-loader.gif' ); ?>" 
			alt="<?php esc_attr_e( 'processing...', 'wpbk' ); ?>">
	</p>
	</br>
	<div id="book-result" name="book_result"></div>
</div>
