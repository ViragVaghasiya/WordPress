<?php
/**
 * Dsignfly Feature Bar Content.
 *
 * @package Dsignfly
 */

$portfolio_cats = get_terms(
	array(
		'taxonomy'   => 'dsign_portfolio_category',
		'number'     => 3,
		'hide_empty' => false,
	)
);
?> 

<?php if ( ! empty( $portfolio_cats ) && ! is_wp_error( $portfolio_cats ) ) : ?>
	<section id="dsignfly-features-section" class="content-style-full-width">
		<div id="dsignfly-features-content" class="content-style-cropped-width">

		<?php foreach ( $portfolio_cats as $portfolio_cat ) : ?>
			<div class="dsignfly-feature">
				<div class="dsignfly-feature-icons">
					<button id="dsigfly-<?php echo esc_attr( strtolower( $portfolio_cat->name ) ); ?>"
						class="dsignfly-feature-icon">
					</button>
				</div> 
				<div class="dsignfly-features-text">
					<a href="<?php echo esc_url( get_category_link( $portfolio_cat->term_id ) ); ?>"
						class="dsignfly-feature-title font-bold">
						<?php echo esc_html( $portfolio_cat->name ); ?>
					</a>
					<p class="dsignfly-features-paragraph font-regular"><?php echo esc_html( $portfolio_cat->description ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>

		</div>
	</section>
<?php endif; ?>
