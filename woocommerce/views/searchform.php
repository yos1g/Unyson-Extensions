<?php

$form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/' ) ) . '">
	<div>
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search...', 'fw' ) . '" />
	<input type="hidden" name="post_type" value="product" />
	</div>
	</form>';
echo $form;