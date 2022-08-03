<?php
/**
 * Removes residual data on plugin uninstalation
 *
 * @package wpbook
 */

/**
 * Plugin deep cleanup class
 */
class WPBk_Clean_Uninstall {

	/**
	 * Uninstalls wp_book plugin related things
	 *
	 * @return void|string
	 */
	public static function wpbk_book_plugin_uninstall() {

		try {
			// phpcs:disable
			global $wpdb;
			// retrieves book ids
			$book_ids = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE post_type = %s", 'wpbk_book' ) );
			// wp object to array conversion
			$book_id_arr = array();
			if ( !empty( $book_ids ) ) {
				foreach ( $book_ids as $book ) {
					$book_id_arr[] = $book->ID;
				}
			}
	
			if ( !empty( $book_id_arr ) ) {
				$book_id_arr = array_unique($book_id_arr);
				 // retrieves term and taxonomy ids
				$term_ids = $wpdb->get_results( 
					$wpdb->prepare( "SELECT {$wpdb->prefix}term_taxonomy.term_id , {$wpdb->prefix}term_relationships.term_taxonomy_id 
					FROM {$wpdb->prefix}term_relationships 
					LEFT JOIN {$wpdb->prefix}term_taxonomy ON {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}term_relationships.term_taxonomy_id 
					WHERE {$wpdb->prefix}term_relationships.object_id IN (" . trim( str_repeat( ',%s', count($book_id_arr) ), ',' ) . ')', $book_id_arr ) );

				// wp object to array conversion
				$term_arr = array();
				if ( !empty( $term_ids ) ) {
					foreach ( $term_ids as $term ) {
						$term_arr['term'][] = $term->term_id;
						$term_arr['term_taxonomy'][] = $term->term_taxonomy_id;
					}
				}

				// deletes terms relationships
				$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}term_relationships WHERE object_id IN (" . trim( str_repeat( ',%s', count($book_id_arr) ), ',' ) .  ')', $book_id_arr ) );
				
				
				// deletes terms and term taxonomy
				if ( !empty( $term_arr ) ) {
					$term_arr['term'] = array_unique($term_arr['term']);
					$term_arr['term_taxonomy'] = array_unique($term_arr['term_taxonomy']);
					if ( !empty( $term_arr['term'] ) ) {
						$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}term_taxonomy WHERE term_taxonomy_id IN ("  . trim( str_repeat( ',%s', count($term_arr['term_taxonomy']) ), ',' ) .   ') ', $term_arr['term_taxonomy'] ) );
					} 
					if ( !empty( $term_arr['term_taxonomy'] ) ) {
						$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}terms WHERE term_id IN ("  . trim( str_repeat( ',%s', count($term_arr['term']) ), ',' ) .  ')', $term_arr['term'] ) );
					}
				}

				// deletes book posts
				$wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}posts WHERE post_type = 'wpbk_book' OR post_parent IN ("  . trim( str_repeat( ',%s', count($book_id_arr) ), ',' ) .  ') ', $book_id_arr  ) );
			}
			// phpcs:enable

			// deletes bookmeta table.
			$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpbk_bookmeta" );

			// deletes settings options.
			delete_option( 'wpbk_base_currency' );
			delete_option( 'wpbk_display_book_currency_unit' );
			delete_option( 'wpbk_display_currency_fx_rate_type' );
			delete_option( 'wpbk_forex_rate' );
			delete_option( 'wpbk_books_per_page' );
			delete_option( 'wpbk_book_info_display' );
			if ( get_transient( 'wpbk_api_usd_forex_rates' ) ) {
				delete_transient( 'wpbk_api_usd_forex_rates' );
			}
			if ( get_transient( 'wpbk_api_eur_forex_rates' ) ) {
				delete_transient( 'wpbk_api_eur_forex_rates' );
			}
			if ( get_transient( 'wpbk_api_inr_forex_rates' ) ) {
				delete_transient( 'wpbk_api_inr_forex_rates' );
			}
			flush_rewrite_rules();
		} catch ( Exception $e ) {
			return esc_html__( ' Unable to completely uninstall plugin ', 'wpbk' );
		}
	}
}
