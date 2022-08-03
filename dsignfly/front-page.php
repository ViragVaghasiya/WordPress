<?php
/**
 * Dsignfly Home Page Content.
 *
 * @package Dsignfly
 */

get_header();

?>

<?php get_template_part( 'template-parts/dsignfly-carousel', 'content' ); ?>
<?php get_template_part( 'template-parts/dsignfly-features', 'content' ); ?>

<section id="dsignfly-image-gallery-container" class="content-style-cropped-width">
	<div id="dsignfly-image-gallery-header">
		<h4 id="dsignfly-image-gallery-title" class="font-light dsignfly-title">
			D'SIGN <?php esc_html_e( 'IS THE SOUL', 'dsignfly-theme' ); ?>
		</h4>
		<a id="dsignfly-image-gallery-button"
			href="<?php echo esc_url( get_permalink( get_page_by_path( 'portfolio' ) ) ); ?>" class="font-regular">
			<?php esc_html_e( 'view all', 'dsignfly-theme' ); ?>
		</a>
	</div>
	<hr id="line1">
	<div id="dsignfly-image-gallery">
		<?php
		$args     = array(
			'numberposts' => 6,
			'fields'      => 'ids',
			'post_type'   => 'dsign_portfolio',
			'meta_query'  => array(
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			),
		);
		$homeloop = get_posts( $args );
		?>

		<?php if ( ! empty( $homeloop ) ) : ?>
			<?php foreach ( $homeloop as $portfolio_post_id ) : ?>
				<?php if ( has_post_thumbnail( $portfolio_post_id ) ) : ?>
					<div class="dsignfly-image-box"> 
						<?php
						echo wp_kses( get_the_post_thumbnail( $portfolio_post_id ), POST_ALLOWED_HTML_TAGS );
						?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<h2 class="font-regular not-found"><?php esc_html_e( 'No post found...', 'dsignfly-theme' ); ?></h2>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
