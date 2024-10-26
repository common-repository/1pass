<?php

/**
 * Get the path to the 1Pass logo image
 *
 * @return string
 */
function onepass_get_logo_src() {
    return ONEPASS_PLUGIN_URL . 'img/1pass-logo.png';
}

/**
 * Load the API credentials for the appropriate environment, live or test
 *
 * @param string $env
 * @return array
 */
function onepass_load_credentials( $env ) {

    $set = sprintf( 'onepass_%s_credentials', $env );
	$credentials = get_option( $set );

	if( !isset( $credentials['secret_key'] ) ) {
		$credentials['secret_key'] = '';
	}

	if( !isset( $credentials['publishable_key'] ) ) {
		$credentials['publishable_key'] = '';
	}

	return $credentials;
}

/**
 * Are we in test mode?
 *
 * @return bool
 */
function onepass_is_test_environment() {
	return apply_filters( 'onepass_is_test_environment', false );
}

/**
 * Get the 1Pass environment, 'test' or 'live'
 * @return string
 */
function onepass_get_environment() {
	return onepass_is_test_environment() ? 'test' : 'live';
}

/**
 * Get the URL of the 1Pass domain
 * @return string
 */
function onepass_get_onepass_domain() {
    return apply_filters( 'onepass_domain', 'https://1pass.me' );
}

/**
 * Is 1Pass set up yet?
 *
 * @todo make this smarter
 *
 * @return bool
 */
function onepass_is_set_up() {
	$creds = onepass_load_credentials( onepass_get_environment() );
	$creds = array_filter( $creds );
	return isset($creds['secret_key']) && isset($creds['publishable_key']) ;
}

/**
 * Is this post a 1Pass post?
 */
function is_onepass( $post = null ) {
	if( !$post ) { global $post; }
	if( !$post ) { return; }
	return has_term( '1pass', '1pass', $post );
}

/**
 * Wrap get_the_guid(), decoding special characters.
 *
 * This is to work around a bug in WordPress:
 * https://core.trac.wordpress.org/ticket/24248
 *
 * Under some circumstances WP will create GUIDs with escaped characters.
 * Once they become part of the HTML document these characters
 * (such as &#038; for an ampersand) are converted into their human-readable
 * representations. This means that when the 1Pass embed reads out the attribute
 * values from the embed, it ends up with a different guid than the publisher
 * passed in.
 *
 * @param int $post_id optional
 * @return string
 */
function onepass_get_the_guid( $post_id = null ) {
	return htmlspecialchars_decode( get_the_guid( $post_id ) );
}
