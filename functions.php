<?php

/**
 * Ninthlink PGB Child Theme
 *
 * nlk-pgb functions and definitions
 *
 */

add_action( 'wp_enqueue_scripts', 'pgb_child_enqueue_styles' );
function pgb_child_enqueue_styles() {
	wp_enqueue_style( 'nlk', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'pgb_child_enqueue_scripts' );
function pgb_child_enqueue_scripts() {
	wp_enqueue_script( 'nlk-js', get_stylesheet_directory_uri() . '/js/nlk.js', array('jquery') );
}


add_action( 'template_redirect', array( 'NLKTheme', 'templateRedirect' ) );
add_action( 'pgb_block_navbar', array( 'NLKTheme', 'navbarLeft' ), 10 ); // Add new left menu
add_action( 'pgb_block_navbar', array( 'NLKTheme', 'menuslidepanel' ), 20 ); // Add menu slidepanelout page
add_action( 'pgb_block_navbar', array( 'NLKTheme', 'socialslidepanel' ), 30 ); // Add menu slidepanelout page

class NLKTheme {
	static function templateRedirect() {
		remove_action( 'pgb_block_navbar', 'pgb_load_block_navbar', 10 );
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

