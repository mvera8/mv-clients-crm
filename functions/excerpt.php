<?php
/**
 * Excerpt length
 *
 * @package petbook
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

function tincho_excerpt_length( $length ) {
	return 7;
}

add_filter( 'excerpt_length', 'tincho_excerpt_length', 999 );

function tincho_excerpt_more( $more ) {
	return '...';
}   
add_filter('excerpt_more', 'tincho_excerpt_more');