<?php

/**
 * Initialise the front end
 */
function onepass_init() {

    onepass_set_environment();
    onepass_initialise_atom_feed();

    if( onepass_use_content_restrictions() ) {
        onepass_initialise_content_restrictions();
    }

}

/**
 * Initialise the admin end
 */
function onepass_admin_init() {
	wp_enqueue_script( 'onepass-admin', ONEPASS_PLUGIN_URL.'js/admin.js' );
    wp_enqueue_style( 'onepass-admin', ONEPASS_PLUGIN_URL.'css/admin.css' );
    onepass_set_environment();
}

add_action( 'init', 'onepass_init' );
add_action( 'admin_init', 'onepass_admin_init' );

/**
 * Enable the paywall?
 *
 * @return bool
 */
function onepass_use_content_restrictions() {
    return (bool) get_option( 'onepass_use_content_restrictions' );
}


/**
 * Set up environment-specific settings, if appropriate
 *
 * @return void
 */
function onepass_set_environment() {
	if( get_option( 'onepass_environment' ) === 'test' ) {
        add_filter( 'onepass_is_test_environment', '__return_true' );
		add_filter( 'onepass_domain', function() { return 'https://demo.1pass.me'; } );
	}

	if( defined( 'ONEPASS_DEV' ) && ONEPASS_DEV ) {
		add_filter( 'onepass_domain', function() { return 'http://localhost:3000'; }, 11 );
	}
}
