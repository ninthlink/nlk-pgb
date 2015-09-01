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