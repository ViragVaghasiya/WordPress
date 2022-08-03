<?php
/**
 * Dsignfly Custom Customizer Settings Handler.
 *
 * @package Dsignfly
 */

/**
 * Dsignfly Theme Custom Customizer Settings
 */
class Dsignfly_Customizer_Settings {

	/**
	 * Registers a customizer function
	 */
	public function __construct() {
		add_action( 'customize_register', array( $this, 'dsignfly_register_customize_settings' ) );
	}

	/**
	 * Adds Custom Customizer Sections & Settings
	 *
	 * @param object $wp_customize WordPress customizer object.
	 * @return void
	 */
	public function dsignfly_register_customize_settings( $wp_customize ) {
		$this->dsignfly_image_carousel_customizer( $wp_customize );
		$this->dsignfly_footer_customizer( $wp_customize );
	}

	/**
	 * Sanitizes input allowing html
	 *
	 * @param string $input input to sanitize.
	 * @return string
	 */
	public function dsignfly_sanitize_with_html( $input ) {
		$allowed_html = wp_kses_allowed_html( 'post' );
		return wp_kses( $input, $allowed_html );
	}

	/**
	 * Image Carousel Content Customizer
	 *
	 * @param object $wp_customize WordPress customizer object.
	 * @return void
	 */
	private function dsignfly_image_carousel_customizer( $wp_customize ) {

		// adds image carousel customizer section.
		$wp_customize->add_section(
			'dsignfly-image-carousel-section',
			array(
				'title'       => __( 'Dsignfly Homepage Image Carousel', 'dsignfly-theme' ),
				'priority'    => 2,
				'description' => __( 'The image Carousel is only displayed on the Home page.', 'dsignfly-theme' ),
			)
		);

		// adds carousel title setting.
		$wp_customize->add_setting(
			'dsignfly-img-carousel-title',
			array(
				'sanitize_callback' => 'sanitize_text_field',
			)
		);

		// adds carousel title control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-img-carousel-title-control',
				array(
					'label'    => __( 'Image Carousel Title', 'dsignfly-theme' ),
					'section'  => 'dsignfly-image-carousel-section',
					'settings' => 'dsignfly-img-carousel-title',
					'type'     => 'text',
				)
			)
		);

		// adds carousel description setting.
		$wp_customize->add_setting(
			'dsignfly-img-carousel-description',
			array(
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);

		// adds carousel description control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-img-carousel-description-control',
				array(
					'label'    => __( 'Image Carousel Description', 'dsignfly-theme' ),
					'section'  => 'dsignfly-image-carousel-section',
					'settings' => 'dsignfly-img-carousel-description',
					'type'     => 'textarea',
				)
			)
		);

		$wp_customize->add_setting(
			'dsignfly-img-carousel-url-01',
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'dsignfly-img-carousel-url-control-01',
				array(
					'label'    => 'Carousel Image 01',
					'section'  => 'dsignfly-image-carousel-section',
					'settings' => 'dsignfly-img-carousel-url-01',
				)
			)
		);

		$wp_customize->add_setting(
			'dsignfly-img-carousel-url-02',
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'dsignfly-img-carousel-url-control-02',
				array(
					'label'    => 'Carousel Image 02',
					'section'  => 'dsignfly-image-carousel-section',
					'settings' => 'dsignfly-img-carousel-url-02',
				)
			)
		);

		$wp_customize->add_setting(
			'dsignfly-img-carousel-url-03',
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'dsignfly-img-carousel-url-control-03',
				array(
					'label'    => 'Carousel Image 03',
					'section'  => 'dsignfly-image-carousel-section',
					'settings' => 'dsignfly-img-carousel-url-03',
				)
			)
		);

		$wp_customize->add_setting(
			'dsignfly-img-carousel-url-04',
			array(
				'type'              => 'theme_mod',
				'capability'        => 'edit_theme_options',
				'sanitize_callback' => 'esc_url',
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'dsignfly-img-carousel-url-control-04',
				array(
					'label'    => 'Carousel Image 04',
					'section'  => 'dsignfly-image-carousel-section',
					'settings' => 'dsignfly-img-carousel-url-04',
				)
			)
		);
	}

	/**
	 * Dsignfly Footer Content Customizer
	 *
	 * @param object $wp_customize WordPress customizer object.
	 * @return void
	 */
	private function dsignfly_footer_customizer( $wp_customize ) {

		// adds footer customizer section.
		$wp_customize->add_section(
			'dsignfly-footer-section',
			array(
				'title'       => __( 'Dsignfly Footer', 'dsignfly-theme' ),
				'priority'    => 2,
				'description' => __( 'The Dsignfly Footer displayed at bottom of every page.', 'dsignfly-theme' ),
			)
		);

		// adds footer welcome title setting.
		$wp_customize->add_setting(
			'dsignfly-footer-welcome-title',
			array(
				'sanitize_callback' => array( $this, 'dsignfly_sanitize_with_html' ),
			)
		);

		// adds footer welcome title control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-footer-welcome-title-control',
				array(
					'label'    => __( 'Footer Welcome Title', 'dsignfly-theme' ),
					'section'  => 'dsignfly-footer-section',
					'settings' => 'dsignfly-footer-welcome-title',
					'type'     => 'text',
				)
			)
		);

		// adds footer welcome description setting.
		$wp_customize->add_setting(
			'dsignfly-footer-welcome-description',
			array(
				'sanitize_callback' => array( $this, 'dsignfly_sanitize_with_html' ),
			)
		);

		// adds footer welcome description control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-footer-welcome-description-control',
				array(
					'label'    => __( 'Footer Welcome Description', 'dsignfly-theme' ),
					'section'  => 'dsignfly-footer-section',
					'settings' => 'dsignfly-footer-welcome-description',
					'type'     => 'textarea',
				)
			)
		);

		// adds footer contact us title setting.
		$wp_customize->add_setting(
			'dsignfly-footer-contact-us-title',
			array(
				'sanitize_callback' => array( $this, 'dsignfly_sanitize_with_html' ),
			)
		);

		// adds footer contact us title control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-footer-contact-us-title-control',
				array(
					'label'    => __( 'Footer Contact Us Title', 'dsignfly-theme' ),
					'section'  => 'dsignfly-footer-section',
					'settings' => 'dsignfly-footer-contact-us-title',
					'type'     => 'text',
				)
			)
		);

		// adds footer contact us description setting.
		$wp_customize->add_setting(
			'dsignfly-footer-contact-us-description',
			array(
				'sanitize_callback' => array( $this, 'dsignfly_sanitize_with_html' ),
			)
		);

		// adds footer contact us description control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-footer-contact-us-description-control',
				array(
					'label'    => __( 'Footer Contact Us Description', 'dsignfly-theme' ),
					'section'  => 'dsignfly-footer-section',
					'settings' => 'dsignfly-footer-contact-us-description',
					'type'     => 'textarea',
				)
			)
		);

		// adds footer copyright setting.
		$wp_customize->add_setting(
			'dsignfly-footer-copyright-content',
			array(
				'sanitize_callback' => array( $this, 'dsignfly_sanitize_with_html' ),
			)
		);

		// adds footer copyright control.
		$wp_customize->add_control(
			new WP_Customize_Control(
				$wp_customize,
				'dsignfly-footer-copyright-content-control',
				array(
					'label'    => __( 'Footer Copyright Content', 'dsignfly-theme' ),
					'section'  => 'dsignfly-footer-section',
					'settings' => 'dsignfly-footer-copyright-content',
					'type'     => 'textarea',
				)
			)
		);
	}
}
