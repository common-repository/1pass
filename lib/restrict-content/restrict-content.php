<?php

/**
 * Set up content restrictions
 *
 * @return void
 */
function onepass_initialise_content_restrictions() {
	add_action( 'template_redirect', 'onepass_select_post_for_truncation', 11 );
}

/**
 *
 * Prepare to show 1Pass buttons on the post if required
 *
 * Needs to be hooked after the main query has run, but before the content is
 * rendered. 'template_redirect' is ok.
 *
 * @return void
 */
function onepass_select_post_for_truncation() {
	global $post;

    /**
	 * If 1Pass is loaded, it will search the post content for the [1pass] shortcode,
	 * truncate the post at that point, and inject the [_1pass] shortcode which
	 * actually loads the embed code
	 */
	if( is_onepass() && onepass_restrict_post( $post ) && !is_feed() ) {
		onepass_truncate_post( $post );
    }
}

/**
 * Truncate the post_content property of a Post object, inserting the 1Pass
 * shortcode at the end to create the 1Pass button.
 */
function onepass_truncate_post( &$post ) {
	// WordPress unfilterably inserts read more,
	// so we have to look for it in the resulting
	// string
	//
	// cf. wp-includes/post-template.php:301
	$read_more_string = '<!--more-->';
	if( strpos( $post->post_content, $read_more_string ) !== FALSE ) {
		list( $teaser, $content ) = explode( $read_more_string,  $post->post_content );
		return $post->post_content = $teaser . '[_1pass]';
	}
}

/**
 * This function decides whether to show a post or not.
 *
 * If it returns true, the post will be truncated.
 *
 * Filter on onepass_restrictions to add a condition.
 *
 * @return bool
 */
function onepass_restrict_post( $post ) {
    return apply_filters( 'onepass_restrictions', false, $post );
}

/**
 * This function sets a rule for which users see the button.
 * If it returns true, the button will be shown.
 * Feel free to unhook it and override it.
 *
 * @return bool
 */
function onepass_reject_unauthorised_users() {
    return !current_user_can( 'edit_posts' );
}

add_filter( 'onepass_restrictions', 'onepass_reject_unauthorised_users' );
