<?php
/**
 * Dsignfly Single Post Page.
 *
 * @package Dsignfly
 */

get_header();
get_template_part( 'template-parts/dsignfly-features', 'content' );

// updates post view for popular post widget.
dsignfly_set_post_views( get_the_ID() );

?>

<section id="dsignfly-single-post-page-container" class="content-style-cropped-width">
	<div id="dsignfly-single-post-container">
		<div class="dsignfly-single-post title-bar">
			<h1 id="dsingfly-single-post-title" class="dsignfly-title font-regular">
				<?php the_title(); ?> 
			</h1>
			<div class="dsignfly-single-post-body-content">
				<div class="dsignfly-post-body-metadata">
					<div class="dsignfly-post-body-author">
						<?php esc_html_e( 'by', 'dsignfly-theme' ); ?>
						<a href="<?php echo esc_url( get_author_posts_url( $post->post_author ) ); ?>" 
							id="dsignfly-author-link" class="dsignfly-orange-link">
							<?php the_author_meta( 'display_name', $post->post_author ); ?>
						</a>
						<?php echo esc_html__( 'on', 'dsignfly-theme' ) . get_the_date( ' j F, Y ' ); ?>
					</div>
					<a class="dsignfly-post-body-author-comments dsignfly-orange-link"
						href="#dsignfly-single-post-all-comments"> 
						<?php echo esc_html( get_comment_count( get_the_ID() )['total_comments'] . ' ' . __( 'Comments', 'dsignfly-theme' ) ); ?> 
					</a>
				</div>
			</div>
			<hr>
		</div>

		<div class="dsingfly-single-post-content font-regular">
			<?php
			the_content();
			$dsign_tags = get_the_terms( get_the_ID(), 'dsign_portfolio_tag' );
			$tags_str   = '';
			if ( ! empty( $dsign_tags ) && ! is_wp_error( $dsign_tags ) ) {
				foreach ( $dsign_tags as $dsign_tag ) {
					$tags_str .= ' <a class="dsignfly-orange-link"
						href="' . esc_url( get_tag_link( $dsign_tag ) ) . '">' . $dsign_tag->name . '</a> ,';
				}
				if ( ! empty( $tags_str ) ) {
					$tags_str = trim( $tags_str, ', ' );
				}
			}
			?>
			<div class="dsignfly-post-tags font-regular">
				<?php if ( ! empty( $tags_str ) ) : ?>
					<p> <?php echo esc_html( __( 'TAGS', 'dsignfly-theme' ) ) . ': ' . wp_kses( $tags_str, POST_ALLOWED_HTML_TAGS ); ?> </p>
				<?php endif; ?>
			</div>
		</div>
		<?php comments_template(); ?> 
	</div>
	<?php get_sidebar( 'dsignfly-sidebar' ); ?>
</section>

<?php get_footer(); ?>
