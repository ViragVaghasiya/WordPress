<?php
/**
 * Dsignfly Comments & Comments Form Content.
 *
 * @package Dsignfly
 */

$comment_form_args = array(
	'fields'               => apply_filters(
		'comment_form_default_fields',
		array(
			'author'  =>
				'<div id="dsignfly-post-comment-form-name">' .
					'<h4 class="dsignfly-post-comment-form-label font-regular">' . __( 'Name', 'dsignfly-theme' ) . ' </h4>' .
					'<input id="author" name="author" class="dsignfly-post-comment-form-input" type="text"
						value="' . esc_attr( $commenter['comment_author'] ) . '" />' .
				'</div>',
			'email'   =>
				'<div id="dsignfly-post-comment-form-email">' .
					'<h4 class="dsignfly-post-comment-form-label font-regular">' . __( 'Email', 'dsignfly-theme' ) . ' </h4>' .
					'<input id="email" name="email" class="dsignfly-post-comment-form-input" type="email"
						value="' . esc_attr( $commenter['comment_author_email'] ) . '" />' .
				'</div>',
			'url'     =>
				'<div id="dsignfly-post-comment-form-website">' .
					'<h4 class="dsignfly-post-comment-form-label font-regular">' . __( 'Website', 'dsignfly-theme' ) . '</h4>' .
					'<input id="url" name="url" class="dsignfly-post-comment-form-input" type="url"
						value="' . esc_attr( $commenter['comment_author_url'] ) . '" />' .
				'</div>',
			'cookies' => '',
		)
	),
	'comment_field'        =>
		'<div id="dsignfly-post-comment-form-comment">' .
			'<h4 id="dsignfly-post-comment-form-label" class="font-regular"> ' . __( 'Post Your Comment', 'dsignfly-theme' ) . ' </h4>' .
			'<textarea id="comment" name="comment" name="" class="dsignfly-post-comment-form-input" rows="6"></textarea>' .
		'</div>',
	'submit_button'        =>
	'<button id="submit" class="dsignfly-post-comment-submit-btn dsign-cursor-pointer font-regular" type="submit"> ' .
		__( 'Submit ', 'dsignfly-theme' ) .
	'</button>',
	'label_submit'         => __( 'Submit', 'dsignfly-theme' ),
	'comment_notes_before' => '',
	'comment_notes_after'  => '',
	'title_reply'          => '',
	'id_form'              => 'dsignfly-comment-form',
);

$comment_args = array(
	'style'       => 'li',
	'per_page'    => 3,
	'avatar_size' => 13,
	'callback'    => 'dsignfly_comments_format',
);
?>

<div class="dsingfly-single-post-comments-container font-regular">
	<hr id="line5">
	<?php if ( have_comments() ) : ?>
		<div id="dsignfly-single-post-all-comments">
			<h2 class="dsingfly-post-comment-title font-regular"> <?php esc_html_e( 'Comments', 'dsignfly-theme' ); ?> </h2>
			<hr id="line4">
			<?php wp_list_comments( $comment_args ); ?>
		</div>
	<?php endif; ?> 
	<div class="dsignfly-comment-post-form-container font-regular">
		<?php comment_form( $comment_form_args ); ?> 
	</div>
</div>
