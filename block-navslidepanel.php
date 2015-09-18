<?php
/**
 * Nav slidepanel out
 *
 * @package nlkpgb
 */

?>
<div id="menu-slidepanel" class="slidepanel">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-lg-3">
				<?php wp_nav_menu( array( 'theme_location' => 'page_order', 'items_wrap' => '<ul id="%1$s" class="nav nav-pills nav-stacked %2$s">%3$s</ul>', 'depth' => 1 ) ); ?>
			</div>
			<div class="col-sm-6 col-md-8 col-lg-9">
				Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo deleniti, quas consectetur itaque voluptates fuga quibusdam, voluptatum, dolores, libero sed mollitia? Non necessitatibus corporis in cumque quasi, animi nostrum veniam!
			</div>
		</div>
	</div>
</div>