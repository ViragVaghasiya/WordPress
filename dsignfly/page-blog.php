<?php
/**
 * Dsignfly Blog Page.
 *
 * @package Dsignfly
 */

get_header();

get_template_part( 'template-parts/dsignfly-features', 'content' );
$posts_data = new WP_Query(
	array(
		'post_type'      => 'dsign_portfolio',
		'posts_per_page' => 5,
		'paged'          => ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1,
	)
);

?>

<section id="dsignfly-blog-page-content-container" class="content-style-cropped-width">
	<div id="dsignfly-blog-content">
		<h1 class="dsignfly-title font-light"> <?php esc_html_e( "LET'S BLOG", 'dsignfly-theme' ); ?> </h1>
		<hr>

		<?php if ( $posts_data->have_posts() ) : ?>
			<?php while ( $posts_data->have_posts() ) : ?>
				<?php $posts_data->the_post(); ?>
				<div class="dsignlfy-posts-content">
					<div class="dsignfly-post-header dsign-cursor-pointer" onclick="location.href='<?php echo esc_url( get_permalink() ); ?>'">
						<div class="dsignfly-post-header-date">
							<h3 class="dsignfly-post-header-date-dd font-regular">
								<?php the_modified_time( 'j' ); ?>
							</h3>
							<h4 class="dsignfly-post-header-date-mm font-regular">
								<?php the_modified_time( 'F' ); ?>
							</h4>
						</div>
						<h3 class="dsignfly-post-header-title font-regular"> <?php the_title(); ?> </h3>
					</div>
					<div class="dsignfly-post-body font-regular">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'post-thumbnail',
								array(
									'class'   => 'dsignfly-post-body-image dsign-cursor-pointer',
									'onclick' => "location.href ='" . esc_url( get_permalink() ) . "'",
								)
							);
						}
						?>
						<div class="dsignfly-post-body-content">
							<div class="dsignfly-post-body-metadata">
								<div class="dsignfly-post-body-author">
									<?php esc_html_e( 'by', 'dsignfly-theme' ); ?>
									<a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" id="dsignfly-author-link" class="dsignfly-orange-link"><?php the_author(); ?></a>
									<?php echo get_the_date( ' j F, Y ' ); ?>
								</div> 
								<?php if ( have_comments() ) : ?>
									<p class="dsignfly-post-body-author-comments dsignfly-orange-link">
										<?php echo esc_html( get_comment_count( get_the_ID() ) . ' ' . __( 'Comments', 'dsignfly-theme' ) ); ?>
									</p>
								<?php endif; ?>
							</div>
							<hr>
							<p class="dsignfly-post-body-paragraph"> 
								<?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?>
							</p>
							<a id="dsignfly-welcome-link" class="dsignfly-orange-link"
								href="<?php echo esc_url( get_permalink() ); ?>">
								<?php esc_html_e( 'Read more', 'dsignfly-theme' ); ?>
							</a>
						</div>
					</div>
				</div> 
			<?php endwhile; ?>
		<?php else : ?>
			<h2 class="font-regular not-found"> <?php esc_html_e( 'No post found...', 'dsignfly-theme' ); ?> </h2>
		<?php endif; ?>

		<div class="dsignfly-pagination-container font-semi-bold">
			<?php echo wp_kses( pagination_bar( $posts_data->max_num_pages ), POST_ALLOWED_HTML_TAGS ); ?>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>

	<?php get_sidebar( 'dsignfly-sidebar' ); ?>
</section>
<?php get_footer(); ?>
