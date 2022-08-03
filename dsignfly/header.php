<?php
/**
 * Dsignfly Header Content.
 *
 * @package Dsignfly
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php wp_head(); ?>
</head>
<body>
	<header id="dsignfly-top-header" class="content-style-full-width">
		<div id="dsignfly-top-header-content" class="content-style-cropped-width">
			<a id="dsignfly-header-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" >
				<?php echo wp_kses( get_dsignfly_logo(), POST_ALLOWED_HTML_TAGS ); ?>
			</a>
			<div id="dsignfly-nav-links">
				<?php
				if ( has_nav_menu( 'primary' ) ) {
					wp_nav_menu(
						array(
							'menu'           => 'primary',
							'menu_id'        => 'dsignfly-nav-menu',
							'theme_location' => 'primary',
						)
					);
				}
				?>
			</div>
			<div id="dsignfly-search-bar">
				<?php get_search_form(); ?>
			</div>
		</div>
	</header>
