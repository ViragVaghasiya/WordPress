<?php
/**
 * Dsignfly Portfolio Page.
 *
 * @package Dsignfly
 */

get_header();
get_template_part( 'template-parts/dsignfly-features', 'content' );

?>

<section id="dsignfly-portfolio-gallery-container" class="content-style-cropped-width">
	<div id="dsignfly-image-gallery-header">
		<h4 id="dsignfly-image-gallery-title" class="font-light dsignfly-title">
			D'SIGN <?php esc_html_e( 'IS THE SOUL', 'dsignfly-theme' ); ?>
		</h4>
		<?php
		$portfolio_category = 'dsign_portfolio_category';
		$terms              = get_terms( $portfolio_category );
		$url_var            = false;
		$cat_name           = null;
		$current_cat_class  = null;

		if ( isset( $_GET['dsign-cat'] ) ) {
			$cat_name = sanitize_text_field( wp_unslash( $_GET['dsign-cat'] ) );
		}

		$post_arr = wp_unslash( $_POST );
		if ( isset( $post_arr['dsignfly_portfolio_category_nonce'] ) ) {
			if ( wp_verify_nonce( wp_strip_all_tags( $post_arr['dsignfly_portfolio_category_nonce'] ), 'dsignfly_portfolio_page_category_form' ) ) {
				if ( isset( $post_arr['portfolio-submit'] ) || isset( $post_arr['reset-portfolio'] ) ) {
					if ( isset( $post_arr['reset-portfolio'] ) ) {
						$cat_name = null;
					} elseif ( isset( $post_arr['portfolio-submit'] ) ) {
						$cat_name = $post_arr['portfolio-submit'];
					}
				}
			}
		}
		?>

		<?php if ( $terms && ! is_wp_error( $terms ) ) : ?>
			<div id="dsignfly-portfolio-tags">
				<?php foreach ( $terms as $port_category ) : ?>
					<?php
					if ( strtolower( $port_category->name ) === strtolower( $cat_name ) ) {
						$current_cat_class = 'current-dsign-cat';
					} else {
						$current_cat_class = '';
					}
					?>
					<form action="<?php echo esc_url( get_permalink( get_page_by_path( 'portfolio' ) ) ); ?>" method="POST">
						<input type="submit" name="portfolio-submit"  
							id="dsignfly-cat-<?php echo esc_attr( $port_category->slug ); ?>" 
							class="dsignfly-image-gallery-button dsign-cursor-pointer font-regular <?php echo esc_attr( $current_cat_class ); ?>"
							value="<?php echo esc_attr( $port_category->name ); ?>">
						<?php if ( ! empty( $current_cat_class ) ) : ?>
							<input type="hidden" name="reset-portfolio" value="reset_dsign_portfolio">
						<?php endif; ?>
						<?php wp_nonce_field( 'dsignfly_portfolio_page_category_form', 'dsignfly_portfolio_category_nonce' ); ?>
					</form> 
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
	<hr id="line1">

	<div id="dsignfly-image-gallery">   
		<?php
		$paged_var = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$query_arr =
			array(
				'post_type'      => 'dsign_portfolio',
				'posts_per_page' => 15,
				'paged'          => $paged_var,
				'meta_query'     => array( // phpcs:ignore
					array(
						'key'     => '_thumbnail_id',
						'compare' => 'EXISTS',
					),
				),
			);

		if ( ! empty( $cat_name ) ) {
			$cat_data               = get_term_by( 'name', $cat_name, $portfolio_category );
			$query_arr['tax_query'] = array( // phpcs:ignore
				array(
					'taxonomy' => $cat_data->taxonomy,
					'field'    => 'slug',
					'terms'    => $cat_data->slug,
				),
			);
			$url_var                = strtolower( $cat_name );
		}

		$portfolioloop = new WP_Query( $query_arr );
		?>

		<?php if ( $portfolioloop->have_posts() ) : ?>
			<?php while ( $portfolioloop->have_posts() ) : ?>
				<?php $portfolioloop->the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="dsignfly-image-box dsign-cursor-pointer">
						<?php
						
						the_post_thumbnail(
							'full',
							array(
								'id'    => 'dsignfly-portfolio-image-' . esc_attr( get_the_ID() ),
								'class' => 'dsignfly-image-box-cover dsignfly-portfolio-image-thumbnail',
								'title' => esc_attr( get_the_title( get_the_ID() ) ),
								'alt'   => esc_url( get_permalink( get_the_ID() ) ),
							)
						);
						
						?>
						<div id="dsignfly-image-hover-content">
							<img id="dsignfly-image-gallery-logo"
								src="<?php echo esc_url( get_template_directory_uri() . '/assets/icon/favicon.ico' ); ?>"
								alt="">
							<h5 class="font-semi-bold"><?php esc_html_e( 'View image', 'dsignfly-theme' ); ?></h5>
						</div>
					</div>      
				<?php endif; ?>
			<?php endwhile; ?>
		<?php else : ?>
			<h2 class="font-regular not-found"> <?php esc_html_e( 'No post found...', 'dsignfly-theme' ); ?> </h2>
		<?php endif; ?>
	</div>

	<div id="dsign-image-modal" class="dsign-modal">
		<!-- Modal content -->
		<div id="dsignfly-modal-content">    
			<div id="modal-content-container">
				<div id="dsignfly-modal-image-container">
					<img id="dsignfly-modal-image" src="" alt="Lorem, ipsum dolor sit.">
				</div>
				<div id="modal-content-footer">
					<button id="dsignfly-modal-prev" class="dsignfly-modal-navigation dsign-cursor-pointer"></button>
					<a id="dsignfly-modal-text"></a>
					<button id="dsignfly-modal-next" class="dsignfly-modal-navigation dsign-cursor-pointer"></button>
				</div>
			</div>
			<div id="dsignfly-modal-close">
				<span id="dsign-modal-close">&times;</span>
			</div>
		</div>
	</div>

	<?php wp_reset_postdata(); ?>

	<div id="dsignfly-portfolio-pagination" class="dsignfly-pagination-container font-semi-bold">
		<?php echo wp_kses( pagination_bar( $portfolioloop->max_num_pages, $url_var ), POST_ALLOWED_HTML_TAGS ); ?>
	</div>

</section>
<?php get_footer(); ?>
