<?php
/**
 * Handles book admin settings
 *
 * @package wpbook
 */

/**
 * Book Admin Settings Class
 */
class WPBk_Book_Admin_Settings {

	/**
	 * Admin Books settings page contents
	 *
	 * @return void
	 */
	public function wpbk_admin_page_contents() {
		require_once WPBK_TEMPLATE_DIR . '/book-admin-settings-template.php';
	}

	/**
	 * Adds book setings menu page
	 *
	 * @return void
	 */
	public function wpbk_book_admin_menu() {
		add_submenu_page(
			'edit.php?post_type=wpbk_book',
			'WP Book Settings',
			'Settings',
			'manage_options',
			'wpbk-book-settings',
			array( $this, 'wpbk_admin_page_contents' )
		);
	}

	/**
	 * Adds Books Settings Section and Fields
	 *
	 * @return void
	 */
	public function wpbk_settings_init() {
		if ( class_exists( 'WPBk_Settings_Form_Validator' ) ) {
			$wpbk_validator = new WPBk_Settings_Form_Validator();
			// currency settings section.
			add_settings_section(
				'wpbk_currency_setting_section',
				__( 'Currency Settings', 'wpbk' ),
				null,
				'wpbk_currency_setting_section_group'
			);

			add_settings_field(
				'wpbk_base_currency',
				__( 'Base Currency', 'wpbk' ),
				array( $this, 'wpbk_book_settings_fields' ),
				'wpbk_currency_setting_section_group',
				'wpbk_currency_setting_section',
				array( 'base_currency' )
			);
			register_setting(
				'wpbk_book_currency_settings_group',
				'wpbk_base_currency',
				array(
					'sanitize_callback' => array( $wpbk_validator, 'wpbk_base_currency_dropdown' ),
					'default'           => 'INR',
				)
			);

			add_settings_field(
				'wpbk_display_book_currency_unit',
				__( 'Site\'s Display Currency Unit', 'wpbk' ),
				array( $this, 'wpbk_book_settings_fields' ),
				'wpbk_currency_setting_section_group',
				'wpbk_currency_setting_section',
				array( 'site_currency_field' )
			);
			register_setting(
				'wpbk_book_currency_settings_group',
				'wpbk_display_book_currency_unit',
				array(
					'sanitize_callback' => array( $wpbk_validator, 'wpbk_display_currency_dropdown' ),
					'default'           => get_option( 'wpbk_base_currency' ),
				)
			);

			add_settings_field(
				'wpbk_display_currency_fx_rate_type',
				__( 'Site\'s Display Currency FX Rate Type', 'wpbk' ),
				array( $this, 'wpbk_book_settings_fields' ),
				'wpbk_currency_setting_section_group',
				'wpbk_currency_setting_section',
				array( 'site_currency_fx_rate_field' )
			);
			register_setting(
				'wpbk_book_currency_settings_group',
				'wpbk_display_currency_fx_rate_type',
				array(
					'sanitize_callback' => array( $wpbk_validator, 'wpbk_display_fx_rate_dropdown' ),
					'default'           => 'api_managed',
				)
			);

			add_settings_field(
				'wpbk_forex_rate',
				__( 'Forex Rate Table', 'wpbk' ),
				array( $this, 'wpbk_book_settings_fields' ),
				'wpbk_currency_setting_section_group',
				'wpbk_currency_setting_section',
				array( 'forex_rate_table' )
			);
			register_setting(
				'wpbk_book_currency_settings_group',
				'wpbk_forex_rate',
				array(
					'sanitize_callback' => array( $wpbk_validator, 'wpbk_forex_table_validation' ),
					'default'           => array(
						'INR_USD' => '',
						'INR_EUR' => '',
						'USD_INR' => '',
						'USD_EUR' => '',
						'EUR_INR' => '',
						'EUR_USD' => '',
					),
				)
			);

			add_settings_section(
				'wpbk_acsiblty_section',
				__( 'Accessibility Settings', 'wpbk' ),
				null,
				'wpbk_acsiblty_section_group'
			);

			add_settings_field(
				'wpbk_books_per_page',
				__( 'No. of Books per page', 'wpbk' ),
				array( $this, 'wpbk_book_settings_fields' ),
				'wpbk_acsiblty_section_group',
				'wpbk_acsiblty_section',
				array( 'acsiblty_pagination' )
			);
			register_setting(
				'wpbk_book_acsiblty_settings_group',
				'wpbk_books_per_page',
				array(
					'sanitize_callback' => array( $wpbk_validator, 'wpbk_books_per_page' ),
					'default'           => 10,
				)
			);

			add_settings_field(
				'wpbk_book_info_display',
				__( 'Choose Book Information to Display', 'wpbk' ),
				array( $this, 'wpbk_book_settings_fields' ),
				'wpbk_acsiblty_section_group',
				'wpbk_acsiblty_section',
				array( 'choose_book_info_to_display' )
			);
			register_setting(
				'wpbk_book_acsiblty_settings_group',
				'wpbk_book_info_display',
				array(
					'sanitize_callback' => array( $wpbk_validator, 'wpbk_book_info_to_display' ),
					'default'           => array(),
				)
			);
		}
	}

	/**
	 * Callback Function for Book Settings Fields
	 *
	 * @param array $field_id : id of the field.
	 * @return void
	 */
	public function wpbk_book_settings_fields( array $field_id ) {
		switch ( $field_id[0] ) {
			case 'site_currency_field':
				$wpbk_current_currency = get_option( 'wpbk_display_book_currency_unit' );
				?>
				<select name='wpbk_display_book_currency_unit' id='wpbk_display_book_currency_unit'>
					<?php
					foreach ( WPBK_CURRENCY_OPTIONS as $unit => $unit_label ) {
						?>
						<option <?php selected( $unit, $wpbk_current_currency, true ); ?>
							value='<?php echo esc_attr( $unit ); ?>'> <?php echo esc_html( $unit_label ); ?> </option>
						<?php
					}
					?>
				</select>
				<?php
				break;
			case 'site_currency_fx_rate_field':
				$wpbk_display_fx_rate_type = get_option( 'wpbk_display_currency_fx_rate_type' );
				?>
				<select name="wpbk_display_currency_fx_rate_type" 
					id="wpbk_display_currency_fx_rate_type">
					<?php
					foreach ( WPBK_FX_RATE_TYPES as $fx_type => $fx_label ) {
						?>
						<option <?php selected( $fx_type, $wpbk_display_fx_rate_type, true ); ?>
							value='<?php echo esc_attr( $fx_type ); ?>'> <?php echo esc_html( $fx_label ); ?> 
						</option>
						<?php
					}
					?>
				</select>
				<?php
				break;
			case 'acsiblty_pagination':
				?>
				<input type='number' id='wpbk_books_per_page' 
					name='wpbk_books_per_page' 
					value='<?php echo esc_attr( get_option( 'wpbk_books_per_page' ) ); ?>'>
				<?php
				break;
			case 'base_currency':
				require_once WPBK_TEMPLATE_DIR . '/base-currency-setting-template.php';
				break;
			case 'forex_rate_table':
				require_once WPBK_TEMPLATE_DIR . '/forex-rate-table-setting-template.php';
				break;
			case 'choose_book_info_to_display':
				require_once WPBK_TEMPLATE_DIR . '/display-book-info-setting-template.php';
				break;
		}
	}

	/**
	 * Registers book settings css and js files
	 *
	 * @return void
	 */
	public function wpbk_book_settings_register_assets() {
		wp_enqueue_style(
			'book-info-settings-css',
			WPBK_ASSETS_URL . '/css/book-info-settings.css',
			'',
			WPBK_VERSION
		);

		wp_register_script(
			'book-info-settings-script',
			WPBK_ASSETS_URL . '/js/book-info-settings.js',
			array( 'jquery' ),
			WPBK_VERSION,
			true
		);
		wp_enqueue_script( 'book-info-settings-script' );

		wp_register_script(
			'book-info-price-settings-ajax-script',
			WPBK_ASSETS_URL . '/js/book-info-price-settings-ajax.js',
			array( 'jquery' ),
			WPBK_VERSION,
			true
		);
		wp_enqueue_script( 'book-info-price-settings-ajax-script' );
		wp_localize_script(
			'book-info-price-settings-ajax-script',
			'wpbk_ajax_object',
			array(
				'ajaxurl'   => admin_url( 'admin-ajax.php' ),
				'ajaxnonce' => wp_create_nonce( 'wpbk_update_book_price_or_currency_rates' ),
			)
		);
	}

	/**
	 * Loads Defalt Values for WP Book Settings
	 *
	 * @return void
	 */
	public function wpbk_load_default_settings() {

		if ( false === get_option( 'wpbk_base_currency' ) ) {
			add_option( 'wpbk_base_currency', 'INR' );
		}
		if ( false === get_option( 'wpbk_display_book_currency_unit' ) ) {
			add_option( 'wpbk_display_book_currency_unit', 'INR' );
		}
		if ( false === get_option( 'wpbk_display_currency_fx_rate_type' ) ) {
			add_option( 'wpbk_display_currency_fx_rate_type', 'api_managed' );
		}
		if ( false === get_option( 'wpbk_forex_rate' ) ) {
			add_option( 'wpbk_forex_rate', array() );
		}
		if ( false === get_option( 'wpbk_books_per_page' ) ) {
			add_option( 'wpbk_books_per_page', '10' );
		}
		if ( false === get_option( 'wpbk_book_info_display' ) ) {
			add_option(
				'wpbk_book_info_display',
				array(
					'author_name'    => '1',
					'published_year' => '1',
					'price'          => '1',
					'publisher'      => '1',
					'edition'        => '1',
					'url'            => '1',
					'book_pages'     => '1',
					'description'    => '1',
					'rating'         => '1',
					'language'       => '1',
					'category'       => '1',
					'tag'            => '1',
				)
			);
		}
	}

	/**
	 * Adds actions and filters for book settings and book content
	 *
	 * @return void
	 */
	public function wpbk_add_settings_action() {
		add_action( 'admin_menu', array( $this, 'wpbk_book_admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wpbk_book_settings_register_assets' ) );
		add_action( 'admin_init', array( $this, 'wpbk_settings_init' ) );
		add_action( 'init', array( $this, 'wpbk_load_default_settings' ) );
	}
}
