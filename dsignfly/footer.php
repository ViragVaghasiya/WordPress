<?php
/**
 * Dsignfly Footer Content.
 *
 * @package Dsignfly
 */

wp_footer();

$dsignfly_footer_welcome_title       = get_theme_mod( 'dsignfly-footer-welcome-title', esc_html__( "Welcome to D'SIGN", 'dsignfly-theme' ) . '<i>fly</i>' );
$dsignfly_footer_welcome_description = get_theme_mod(
	'dsignfly-footer-welcome-description',
	esc_html__(
		'Lorem ipsum dolor sit amet, consectetur adipisicing elit.
		Incidunt reprehenderit dolorem ad voluptate voluptates facere explicabo iste tempore
		quis architecto magnam ab cum tenetur totam recusandae amet voluptas, in placeat.',
		'dsignfly-theme'
	)
);
$dsignfly_footer_contact_title       = get_theme_mod( 'dsignfly-footer-contact-us-title', 'Contact us' );
$dsignfly_footer_contact_description = get_theme_mod(
	'dsignfly-footer-contact-us-description',
	'Street 21 Planet, A-11, dapibus tristique. 123 551 </br>'
	. 'tel: 123 4567890; Fax: 123 456789 </br>'
	. esc_html__( 'Email:', 'dsignfly-theme' ) .
	' <a class="dsignfly-orange-link" href="#">contactus@dsignfly.com</a>'
);
$dsignfly_footer_copyright_content   = get_theme_mod(
	'dsignfly-footer-copyright-content',
	'2012 - D\'SIGNfly | ' . __( 'Designed by', 'dsignfly-theme' ) .
	' <a class="dsignfly-orange-link" href="#">Automattic</a>'
);

?>
		<footer class="content-style-cropped-width">
			<hr class="line2">
			<section class="dsignfly-contact-msg-container">
				<div id="dsignfly-welcome-msg">
					<h3 id="dsignfly-welcome-title" class="font-regular dsignfly-subtitle">
						<?php echo wp_kses( $dsignfly_footer_welcome_title, POST_ALLOWED_HTML_TAGS ); ?>
					</h3>
					<p id="dsignfly-welcome-paragraph" class="font-regular dsignfly-paragraph">
						<?php echo wp_kses( $dsignfly_footer_welcome_description, POST_ALLOWED_HTML_TAGS ); ?>
					</p>
					<a id="dsignfly-welcome-link" class="dsignfly-orange-link" href="#"><?php esc_html_e( 'Read more', 'dsignfly-theme' ); ?></a>
				</div>
				<div id="dsignfly-contact-us">
					<h3 id="dsignfly-contact-title" class="font-regular dsignfly-subtitle">
						<?php echo wp_kses( $dsignfly_footer_contact_title, POST_ALLOWED_HTML_TAGS ); ?>
					</h3>
					<p id="dsignfly-welcome-paragraph" class="font-regular dsignfly-paragraph">
						<?php echo wp_kses( $dsignfly_footer_contact_description, POST_ALLOWED_HTML_TAGS ); ?>
					</p>
					<img id="dsignfly-social-image"
						src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/social.png' ); ?>"
						alt="">
				</div>
			</section>
			<hr class="line2">
			<p id="dsignfly-footer" class="dsignfly-paragraph"> &#169;
				<?php echo wp_kses( $dsignfly_footer_copyright_content, POST_ALLOWED_HTML_TAGS ); ?>
			</p>
		</footer>
	</body>
</html>
