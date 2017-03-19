<?php

// Include a hidden H1 on index when a page is set to front and the posts page is also set to a page
if ( is_home() && ! is_front_page() ) : ?>
	<header>
		<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
	</header>

	<?php
endif;