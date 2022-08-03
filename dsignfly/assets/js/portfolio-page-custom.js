// prevents form resubmission on portfolio page
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}

// Get the modal
let modal = document.getElementById("dsign-image-modal");

// Get the <span> element that closes the modal
let closeBtn = document.getElementById("dsign-modal-close");

// When the user clicks on (x), close the modal
if ( closeBtn ) {
  closeBtn.onclick = function() {
    modal.style.display = "none";
  }
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}

// modal element variables
let modalText = jQuery( '#dsignfly-modal-text' );
let modalImage = jQuery( '#dsignfly-modal-image' );
let dsignModal = jQuery( '#dsign-image-modal' );
let nextNav = jQuery( '#dsignfly-modal-next' );
let prevNav = jQuery( '#dsignfly-modal-prev' );

// Portfolio Image Modal Control
jQuery( '.dsignfly-portfolio-image-thumbnail' ).click( function() {
  
  modalImage.attr( 'src', this.src );
  modalText.html( this.title );
  modalText.attr( 'href', this.alt );
  dsignModal.css( 'display', 'table' );
  
  // finds next element with respect to current one
  let nextImageElement = jQuery( '#' + this.id ).closest('.dsignfly-image-box').next().find('.dsignfly-portfolio-image-thumbnail');
  let nextImageElementId = nextImageElement.attr('id');

  // finds prev element with respect to current one
  let prevImageElement = jQuery( '#' + this.id ).closest('.dsignfly-image-box').prev().find('.dsignfly-portfolio-image-thumbnail');
  let prevImageElementId = prevImageElement.attr('id');

  if ( undefined === nextImageElementId ) {
    nextNav.css( 'visibility', 'hidden' );
  } else {
    nextNav.css( 'visibility', 'visible' );
    nextNav.attr( 'name', nextImageElementId );
  }

  if ( undefined === prevImageElementId ) {
    prevNav.css( 'visibility', 'hidden' );
  } else {
    prevNav.css( 'visibility', 'visible' );
    prevNav.attr( 'name', prevImageElementId );
  }
  
});

// modal prev navigation click action
prevNav.click( function() {
  jQuery( '#' + this.name ).trigger('click');
});

// modal next navigation click action
nextNav.click( function() {
  jQuery( '#' + this.name ).trigger('click');
});