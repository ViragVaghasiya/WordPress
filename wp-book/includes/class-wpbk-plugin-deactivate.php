<?php
/**
 * Deactivation file for plugin
 *
 * @package wpbook
 */

/**
 * Clean Deactivates plugin
 */
class WPBk_Plugin_Deactivate {

	/**
	 * Removes and Deregisters plugin related things
	 *
	 * @return void
	 */
	public static function wpbk_remove_plugin_related_stuff() {
		unregister_post_type( 'wpbk_book' );
		unregister_taxonomy( 'wpbk_book_category' );
		unregister_taxonomy( 'wpbk_book_tag' );
		remove_meta_box( 'wpbk-book-information', '', 'advanced' );
		remove_meta_box( 'wpbk-search-book-information', '', 'advanced' );
		unregister_setting( 'wpbk_book_currency_settings_group', 'wpbk_base_currency' );
		unregister_setting( 'wpbk_book_currency_settings_group', 'wpbk_display_book_currency_unit' );
		unregister_setting( 'wpbk_book_currency_settings_group', 'wpbk_display_currency_fx_rate_type' );
		unregister_setting( 'wpbk_book_currency_settings_group', 'wpbk_forex_rate' );
		unregister_setting( 'wpbk_book_acsiblty_settings_group', 'wpbk_books_per_page' );
		unregister_setting( 'wpbk_book_acsiblty_settings_group', 'wpbk_book_info_display' );
		unregister_widget( new WPBk_Category_Books_Widget() );
		unregister_widget( new WPBk_Top_Category_Widget() );
		wp_deregister_script( WPBK_ASSETS_URL . '/js/book-info-form-ajax.js' );
		wp_deregister_script( WPBK_ASSETS_URL . '/js/book-info-settings.js' );
		wp_deregister_script( WPBK_ASSETS_URL . '/js/book-info-price-settings-ajax.js' );
		wp_deregister_style( WPBK_ASSETS_URL . '/css/book-info-settings.css' );
		wp_deregister_style( WPBK_ASSETS_URL . '/css/book-info-form.css' );
		flush_rewrite_rules();
	}
}
