<?php
/**
 * Dsignfly Homepage Image Carousel Content.
 *
 * @package Dsignfly
 */

$carousel_title = get_theme_mod( 'dsignfly-img-carousel-title' );
$carousel_title = ! empty( $carousel_title ) ? $carousel_title : __( 'Gearing up the ideas', 'dsignfly-theme' );

$carousel_description = get_theme_mod( 'dsignfly-img-carousel-description' );
$carousel_description = ! empty( $carousel_description ) ? $carousel_description :
	__(
		'Lorem ipsum, dolor sit amet consectetur adipisicing elit.
		Quibusdam possimus dolorum eum fuga voluptas.',
		'dsignfly-theme'
	);

$carousel_images   = array();
$carousel_images[] = get_theme_mod( 'dsignfly-img-carousel-url-01' );
$carousel_images[] = get_theme_mod( 'dsignfly-img-carousel-url-02' );
$carousel_images[] = get_theme_mod( 'dsignfly-img-carousel-url-03' );
$carousel_images[] = get_theme_mod( 'dsignfly-img-carousel-url-04' );

$carousel_images = array_filter( $carousel_images );

?>

<section id="dsignfly-carousel-section" class="content-style-full-width">

	<img id="static-carousel-image" class="dsignfly-carousel-image active-img selected" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-image.png' ); ?>" alt="">
	<?php foreach ( $carousel_images as $image_url ) : ?>
		<img class="dsignfly-custom-carousel-image dsignfly-carousel-image selected" src="<?php echo esc_url( $image_url ); ?>" alt="">
	<?php endforeach; ?>

	<div id="dsignfly-carousel-text-nav" class="content-style-cropped-width">
		<button id="dsignfly-carousel-prev" class="dsignfly-carousel-navigation dsign-cursor-pointer"></button>
		<button id="dsignfly-carousel-next" class="dsignfly-carousel-navigation dsign-cursor-pointer"></button>
		<div id="dsignfly-carousel-text-content"> 
			<h2 id="dsignfly-carousel-title" class="font-bold"> <?php echo esc_html( $carousel_title ); ?> </h2>
			<p id="dsignfly-carousel-paragraph" class="font-semi-bold"> <?php echo esc_html( $carousel_description ); ?> </p>
		</div>
	</div>

</section>
