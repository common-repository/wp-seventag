<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wp_body_open' ) ) {
	/**
	 * Execute functions hooked on a specific custom action hook - 'wp_body_open'.
	 * According to: https://core.trac.wordpress.org/ticket/12563
	 * Add the following code directly after the <body> tag in your theme:
	 * <?php if ( function_exists( 'wp_body_open' ) ) : wp_body_open(); ?>
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}
