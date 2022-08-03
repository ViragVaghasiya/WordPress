<?php
/**
 * Dsignfly Sidebar.
 *
 * @package Dsignfly
 */

?>


<div id="dsign-sidebar" class="dsignfly-sidebar-area">
	<?php
	if ( is_active_sidebar( 'dsignfly-sidebar' ) ) {
		dynamic_sidebar( 'dsignfly-sidebar' );
	} else {
		$defaults = dsignfly_default_widgets();
		foreach ( $defaults as $default ) {
			echo wp_kses( $default, POST_ALLOWED_HTML_TAGS );
		}
	}
	?>
</div>
