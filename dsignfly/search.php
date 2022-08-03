<?php
/**
 * Dsignfly Search Page.
 *
 * @package Dsignfly
 */

get_header();
get_template_part( 'template-parts/dsignfly-features', 'content' );

?>

<section id="dsignfly-blog-page-content-container" class="content-style-cropped-width">
	<div id="dsignfly-blog-content">
		<h1 class="dsignfly-title font-light">Search : <?php the_search_query(); ?></h1>
		<hr>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<div class="dsignlfy-posts-content">
					<div class="dsignfly-post-header" onclick="location.href='<?php echo esc_url( get_permalink() ); ?>'" >
						<div class="dsignfly-post-header-date">
							<h3 class="dsignfly-post-header-date-dd font-regular">
								<?php the_modified_time( 'j' ); ?>
							</h3>
							<h4 class="dsignfly-post-header-date-mm font-regular">
								<?php the_modified_time( 'F' ); ?>
							</h4>
						</div>
						<h3 class="dsignfly-post-header-title font-regular"><?php the_title(); ?></h3>
					</div>
					<div class="dsignfly-post-body font-regular">
						<?php
						if ( has_post_thumbnail() ) {
							the_post_thumbnail(
								'post-thumbnail',
								array(
									'class'   => 'dsignfly-post-body-image',
									'onclick' => "location.href ='" . esc_url( get_permalink() ) . "'",
								)
							);
						}
						?>
						<div class="dsignfly-post-body-content">
							<div class="dsignfly-post-body-metadata">
								<div class="dsignfly-post-body-author">
									<?php esc_html_e( 'by', 'dsinglfy-theme' ); ?>
									<a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" id="dsignfly-author-link" class="dsignfly-orange-link"><?php the_author(); ?></a>
									<?php echo get_the_date( ' j F, Y ' ); ?>
								</div> 
								<?php if ( have_comments() ) : ?> 
									<p class="dsignfly-post-body-author-comments dsignfly-orange-link"> 
										<?php echo esc_html( get_comment_count( get_the_ID() ) . __( 'Comments', 'dsignfly-theme' ) ); ?> 
									</p> 
								<?php endif; ?> 
							</div>
							<hr>
							<p class="dsignfly-post-body-paragraph"> 
								<?php echo wp_kses( wp_strip_all_tags( get_the_content() ), POST_ALLOWED_HTML_TAGS ); ?>
							</p>
							<a id="dsignfly-welcome-link" class="dsignfly-orange-link" href="<?php echo esc_url( get_permalink() ); ?>">
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
			<?php
				global $wp_query;
				echo wp_kses( pagination_bar( $wp_query->max_num_pages ), POST_ALLOWED_HTML_TAGS );
			?>
		</div>
	</div>
	<?php get_sidebar( 'dsignfly-sidebar' ); ?>
</section>

<?php get_footer(); ?>
