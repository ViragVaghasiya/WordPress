// default carousel image
let defaultImage = jQuery(' #static-carousel-image ');

// last carousel image
let lastElement = jQuery( '.dsignfly-custom-carousel-image:last' );

// auto slide interval
if ( lastElement.length ) {
    setInterval( function() {
        jQuery("#dsignfly-carousel-next").click();
    }, 5000);
}

// carousel next navigation click action
jQuery( '#dsignfly-carousel-next' ).click( function() {

    let activeCarouselImage = jQuery( '.active-img' );
    let nextCarouselImage = activeCarouselImage.next('.dsignfly-carousel-image');

    activeCarouselImage.css('display', 'none');
    if ( nextCarouselImage.length ) {
        activeCarouselImage.removeClass('active-img');
        nextCarouselImage.addClass('active-img');
        nextCarouselImage.css('display', 'revert');
    } else {
        activeCarouselImage.removeClass( 'active-img' );
        defaultImage.addClass( 'active-img' );
        defaultImage.css('display', 'revert');
    }
});

// prev carousel navigation action
jQuery( '#dsignfly-carousel-prev' ).click( function() {
    
    let activeCarouselImage = jQuery( '.active-img' );
    let prevCarouselImage = activeCarouselImage.prev('.dsignfly-carousel-image');
    
    activeCarouselImage.css('display', 'none');
    if ( prevCarouselImage.length ) {
        activeCarouselImage.removeClass('active-img');
        prevCarouselImage.addClass('active-img');
        prevCarouselImage.css('display', 'revert');
    } else if ( lastElement.length ) {
        activeCarouselImage.removeClass( 'active-img' );
        lastElement.addClass( 'active-img' );
        lastElement.css('display', 'revert');
    } else {
        activeCarouselImage.removeClass( 'active-img' );
        defaultImage.addClass( 'active-img' );
        defaultImage.css('display', 'revert');
    }
});

