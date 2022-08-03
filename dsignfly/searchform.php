<?php
/**
 * Dsignfly Search Form.
 *
 * @package Dsignfly
 */

?>

<form role="search" method="get" class="dsignfly-search-form" action="/">
	<input type="search" name="s" id="dsignfly-custom-search" class="search-field font-regular"
		value="<?php echo get_search_query(); ?>" required />
	<button id="dsignfly-search-icon" class="dsign-cursor-pointer" type="submit"></button>
</form>
