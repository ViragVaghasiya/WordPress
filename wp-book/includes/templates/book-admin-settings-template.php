<?php
/**
 * Booka Admin Settings Template File
 *
 * @package wpbook
 */

$wpbk_currency = ( isset( $_GET['action'] ) && 'tab-currency' === sanitize_key( $_GET['action'] ) ) ? true : false; // phpcs:ignore
?>
	<div class="wrap">
		<h1><?php esc_html_e( 'WP Book Settings', 'wpbk' ); ?></h1>
		<h2 class="nav-tab-wrapper">
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=wpbk_book&page=wpbk-book-settings' ) ); ?>" 
				class="nav-tab
				<?php
				if ( ! isset( $_GET['action'] ) ) { // phpcs:ignore
					echo( ' nav-tab-active' );
				}
				?>
				">
				<?php esc_html_e( 'Accessibility' ); ?>
			</a>
			<a href="
				<?php
				echo esc_url(
					add_query_arg(
						array( 'action' => 'tab-currency' ),
						admin_url( 'edit.php?post_type=wpbk_book&page=wpbk-book-settings' )
					)
				);
				?>
				"
				class="nav-tab
				<?php
				if ( $wpbk_currency ) {
					echo( ' nav-tab-active' );
				}
				?>
				">
				<?php esc_html_e( 'Currency' ); ?>
			</a> 
		</h2>

		<form method="post" action="options.php">
		<?php
		if ( $wpbk_currency ) {
			settings_fields( 'wpbk_book_currency_settings_group' );
			do_settings_sections( 'wpbk_currency_setting_section_group' );
			submit_button();
		} else {
			settings_fields( 'wpbk_book_acsiblty_settings_group' );
			do_settings_sections( 'wpbk_acsiblty_section_group' );
			submit_button();
		}
		?>
		</form>
	</div>

