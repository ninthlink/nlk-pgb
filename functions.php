<?php

/**
 * Ninthlink PGB Child Theme
 *
 * nlk-pgb functions and definitions
 *
 */

if ( ! function_exists( 'pgb_child_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function pgb_child_setup() {

	/**
	 * This menu sets the paging order and overall layout
	*/
	register_nav_menus( array(
		'page_order'	=> __( 'Paging Order Menu', 'pgb' ),
	) );

}
endif; // pgb_child_setup
add_action( 'after_setup_theme', 'pgb_child_setup' );


/**
 * Enqueue scripts and stylesheets
 */
add_action( 'wp_enqueue_scripts', 'pgb_child_enqueue_styles' );
function pgb_child_enqueue_styles() {
	wp_enqueue_style( 'nlk', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'pgb_child_enqueue_scripts' );
function pgb_child_enqueue_scripts() {
	global $wp_query;
	wp_enqueue_script( 'nlk-js', get_stylesheet_directory_uri() . '/js/nlk.js', array('jquery') );
	
	wp_enqueue_script( 'ajax-pagination',  get_stylesheet_directory_uri() . '/js/ajax-pagination.js', array( 'jquery' ), '1.0', true );
	wp_localize_script( 'ajax-pagination', 'ajaxpagination', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'query_vars' => json_encode( $wp_query->query )
	));
}





/**
 * Site Layout setup
 */
add_action( 'template_redirect', array( 'NLKThemeLayout', 'removeBlocks' ) ); // Remove unused block/layout elements
add_action( 'pgb_block_navbar', array( 'NLKThemeLayout', 'navbarLeft' ), 10 ); // Add new left menu
add_action( 'pgb_block_navbar', array( 'NLKThemeLayout', 'menuslidepanel' ), 20 ); // Add menu slidepanelout page
add_action( 'pgb_block_navbar', array( 'NLKThemeLayout', 'socialslidepanel' ), 30 ); // Add menu slidepanelout page
//add_action( 'wp_footer', array( 'NLKThemeLayout', 'blockFooterNext' ), 100 ); // Add footer next block

class NLKThemeLayout {

	/**
	 * Layout block modifiers add/remove
	 */
	static function removeBlocks() {
		remove_action( 'pgb_block_navbar', 'pgb_load_block_navbar', 10 );
		remove_action( 'pgb_block_masthead', 'pgb_load_block_masthead', 10 );
	}
	static function navbarLeft() {
		locate_template( 'block-navleft.php', true );
	}
	static function menuslidepanel() {
		locate_template( 'block-navslidepanel.php', true );
	}
	static function socialslidepanel() {
		locate_template( 'block-socialslidepanel.php', true );
	}
}

/**
 * New layout elements
 */
function nlk_get_pagelink_next( $previous = false ) {
	$output = false;
	$class = ( $previous ? 'prev' : 'next' );
	$page_id = ( $previous ? get_previous_page_id() : get_next_page_id() );
	$args = array(
		'post_type'   => array( 'page', 'post' ),
		'post__in'    => array( $page_id )
		);
	$nextpage = new WP_query( $args );

	if ( $nextpage->have_posts() ) :
		while ( $nextpage->have_posts() ) :
			$nextpage->the_post();
			$output = '<div id="next-' . get_the_ID() . '" class="row footer-' . $class . ' text-center" data-target="' . get_permalink() . '" data-id="' . get_the_ID() . '">' .
				'<a href="' . get_permalink() . '"><h3>' . get_the_title() . '</h3>' . get_the_subtitle( get_the_ID(), '<h5 class="page-sub-title">', '</h5>', false ) . '</a></div>';
		endwhile;
	endif;
	return $output;
}
function nlk_pagelink_next() {
	$output = nlk_get_pagelink_next();
	echo $output;
}
function nlk_pagelink_previous() {
	$output = nlk_get_pagelink_next( true );
	echo $output;
}


/**
 * Helper functions
 */
function get_pages_from_menu() {
	$args = array(
		'order'     => 'ASC',
		'orderby'   => 'menu_order',
		);
	$menu_name = 'page_order';
	$pages = array();
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		foreach ($menu_items as $item) {
			if ( ! $item->menu_item_parent ) { // Only top level menu items...
				$id = url_to_postid( $item->url );
				$pages[] = $id;
			}
		}
	}
	array_filter($pages);
	return ( $pages ? $pages : false );
}
function get_next_page_id( $previous = false ) {
	$page_id = false;
	$index = 0;
	$pages = get_pages_from_menu();
	if ( ! $pages ) return false;
	$current_page = ( is_front_page() ? 0 : get_the_ID() );
	if ( in_array( $current_page, $pages ) ) : // Our current page is somewhere in the page stream
		$current_index = array_search( $current_page, $pages );
		$next = $current_index + 1;
		$prev = $current_index - 1;
	else :
		return false;
	endif;
	$index = ( ! $previous ? $next : $prev );
	$page_id = ( array_key_exists($index, $pages) ? $pages[$index] : false );
	return $page_id;
}
function get_previous_page_id() {
	$page_id = get_next_page_id( true );
	return $page_id;
}



/**
 * AJAX
 */
add_action( 'wp_ajax_nopriv_ajax_pagination', 'my_ajax_pagination' );
add_action( 'wp_ajax_ajax_pagination', 'my_ajax_pagination' );

function my_ajax_pagination() {
	$query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
	$data = new stdClass();
	
	$page_id = $_POST['id'];
	$args = array(
		'post_type'   => array( 'page', 'post' ),
		'post__in'    => array( $page_id )
		);
	$nextpage = new WP_query( $args );
	$data->nextpage = $nextpage;

	if ( $nextpage->have_posts() ) :
		while ( $nextpage->have_posts() ) : $nextpage->the_post();
			$data->html = '<article id="post-' . get_the_ID() . '" class="row">' .
				'<header class="col-md-12">' .
				the_title('<h1>', '</h1>', false) .
				'</header>' .
				'<div class="entry-content col-md-12">' .
				nl2br( get_the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'pgb' ) ) ).
				'</div><!-- .entry-content -->' .
				get_footer_next() .
				'</article>';

		endwhile; // end of the loop.
	endif;

	echo json_encode( $data );
	die();
}
