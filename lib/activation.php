<?php

/**
 * Flush rewrite rules
 */
function onepass_flush_rewrite_rules() {
    onepass_initialise_atom_feed();
    flush_rewrite_rules();
}

/**
 * Set default options
 */
function onepass_default_options() {
    $types = get_option( 'onepass_post_types' );
    $env   = get_option( 'onepass_environment' );

    if( !$env ) {
        update_option( 'onepass_environment', 'live' );
    }

    if( !$types ) {
        update_option( 'onepass_post_types', ['post'] );
    }

	update_option( 'onepass_use_content_restrictions', 'on' );
}

/**
 * Enable every available post for 1Pass
 */
function onepass_enable_all_posts() {

	// No init hooks will fire until after plugin activation,
	// so we have to manually register the taxonomy for this request
	onepass_create_taxonomy();

	$query = new WP_Query([
		'fields' => 'ids',
		'post_types' => apply_filters( 'onepass_post_types', get_post_types() ),
		'posts_per_page' => -1
	]);

	if( $query->have_posts() ) {
		foreach( $query->posts as $post_id ) {
			wp_set_object_terms( $post_id, '1pass', '1pass' );
		}
	}
}
