<?php

/**
 * Set up a taxonomy for marking 1Pass-enabled content.
 *
 * Posts marked with 1Pass will be eligible for sale
 */

add_action( 'init', 'onepass_create_taxonomy' );
add_action( 'admin_init', 'onepass_create_taxonomy' );

function onepass_create_taxonomy() {
    $post_types = apply_filters( 'onepass_post_types', get_post_types() );
    if( !$post_types ) {
        return;
    }
    register_taxonomy(
        '1pass',
        $post_types,
        array(
            'label' => '1Pass',
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'rewrite' => false,
            'hierarchical' => true
        )
    );

    if( !term_exists( 'Available on 1Pass', '1pass' ) ) {
        wp_insert_term( 'Available on 1Pass', '1pass', array( 'slug' => '1pass' ) );
    }

}
