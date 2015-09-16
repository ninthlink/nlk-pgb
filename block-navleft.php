<?php
/**
 * Left Nav menu
 *
 * @package nlkpgb
 */

?>
<div id="left-navbar">
	<div class="leftnav-block navbar-top">
		<a id="menu-slidepanel-toggle" data-action="slidepanel" data-target="#menu-slidepanel" data-text="menu" class="" href="#menu-slidepanel" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" >
			<span class="menu-nav-svg"><?php get_template_part('images/svg', 'icongrey'); ?></span>
			<span class="menu-nav-x nth1"></span>
			<span class="menu-nav-x nth2"></span>
			<span class="menu-text">menu</span>
		</a>
	</div>
	<div class="leftnav-block navbar-bottom">
		<a id="social-slidepanel-toggle" data-action="slidepanel" data-target="#social-slidepanel" data-text="social" class="" href="#social-slidepanel" >
			<span class="menu-text">social</span>
			<span class="social-nav-dot nth1"></span>
			<span class="social-nav-dot nth2"></span>
		</a>
	</div>
</div>