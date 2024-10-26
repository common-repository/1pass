<?php

/**
 * Get the necessary data out of a post to pass into the 1Pass service,
 * signing the request to authenticate with the 1Pass servers.
 *
 * By default this function looks up values from the $post object using
 * ordinary WP functions. `onepass_get_` filters are available for each property,
 * and each one is passed the full $post object.
 *
 * @param  WP_Post $post
 * @return array
 */
function onepass_get_params( WP_Post $post ) {
	$env = onepass_get_environment();

	$url        	= get_permalink( $post->ID );
	$title      	= apply_filters( 'onepass_get_title', get_the_title( $post->ID ), $post );
	$author_name 	= apply_filters( 'onepass_get_author', get_the_author_meta( 'nickname', $post->post_author ), $post );
	$ts         	= time();
	$unique_identifier = onepass_get_the_guid( $post->ID );
	$publishable_key   = onepass_load_credentials( $env )['publishable_key'];
	$hash   		= onepass_build_hash( $unique_identifier, $ts );
	$options 		= compact( 'url', 'unique_identifier', 'title', 'author_name', 'publishable_key', 'ts', 'hash' );
	return $options;
}

/**
 * Embed 1Pass
 *
 * @return string
 */
function onepass( $post = null ) {
	if( !$post ) {
		global $post;
	}

	if( !$post ) {
		return;
	}

	if( !is_onepass( $post ) ) {
		return;
	}

	$options = onepass_get_params( $post );

	do_action( 'onepass_before_button' );
	include( ONEPASS_PLUGIN_DIR . 'views/1pass-button.php' );
	do_action( 'onepass_after_button' );
}

/**
 * As onepass(), but returns its content for use in shortcode
 */
function onepass_shortcode() {
	ob_start();
	onepass();
	return ob_get_clean();
}

add_shortcode( '1pass', '__return_false' );
add_shortcode( '_1pass', 'onepass_shortcode' );
