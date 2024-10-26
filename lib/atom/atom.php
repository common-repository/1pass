<?php

use Onepass\Common\AtomFeed;
use Onepass\Common\Article;

/**
 * Set up the feed and make it accessible
 *
 * @return void
 */
function onepass_initialise_atom_feed() {
    add_feed( 'onepass', 'onepass_render_feed' );
    add_rewrite_rule( 'feed/atom/1pass(/)?', 'index.php?feed=onepass&1pass=1pass' );

	/**
	 * Fix for WooCommerce, which overrides WP-Query and hides our content
	 */
	if( function_exists( 'WC' ) ) {
		$woocommerce = WC();
		$q = $woocommerce->query;
		remove_action( 'pre_get_posts', array( $q, 'pre_get_posts' ) );
	}

    add_action( 'pre_get_posts', function( $query ) {
        if( onepass_is_onepass_feed() ) {
            if( !onepass_authenticate( $_SERVER ) ) {
                wp_die( 'Unauthorised', get_bloginfo( 'name' ), array( 'response' => 401 ) );
            }
            $query->set( 'orderby', 'modified' );
            $query->set( 'post_type', apply_filters( 'onepass_post_types', get_post_types() ) );
        }
    });
}

function onepass_get_onepass_feed_url() {
    return site_url( 'feed/atom/1pass/' );
}

function onepass_render_feed() {
    // get the self_link of the feed (WP will only print, not return this value, hence output buffer)
    ob_start();
    self_link();
    $self_link = ob_get_clean();

    $pagination_options = onepass_get_atom_pagination_options();

    $atomFeed = new AtomFeed([
        'publication_url'    => get_bloginfo('url'),
        'publication_title'  => get_bloginfo('title'),
        'updated_timestamp'  => mysql2date('Y-m-d\TH:i:s\Z', get_lastpostmodified('GMT'), false),
        'feed_id'            => onepass_get_onepass_feed_url(),
        'feed_full_url'      => $self_link,
        'charset'            => get_option('blog_charset'),
        'html_media_type'    => get_bloginfo( 'html_type' ),
        'language'           => get_bloginfo( 'language' ),
        'pagination_options' => $pagination_options,
    ]);

    if( !headers_sent() ) {
        foreach ($atomFeed->headers() as $header)
            header($header);
    }

    while ( have_posts() ) {
        the_post();

        $article = new Article([
            'url' => get_permalink(),
            'title' => get_the_title_rss(),
            'author' => get_the_author(),
            'description' => get_the_excerpt(),
            'unique_id' => onepass_get_the_guid(),
            'published' => get_post_time('Y-m-d\TH:i:s\Z', true),
            'last_modified' => get_post_modified_time('Y-m-d\TH:i:s\Z', true),
            'content' => get_the_content_feed('atom'),
        ]);

        $atomFeed->addArticle($article);
    }

    echo $atomFeed->xml();
}

/**
 * Is the current query for an atom feed of 1Pass content?
 *
 * @return bool
 */
function onepass_is_onepass_feed() {
    return get_query_var( 'feed' )  == 'onepass';
}

/**
 * Add pagination links to the atom feed in accordance with the Atom spec
 *
 * @return void
 */
function onepass_get_atom_pagination_options() {

    global $wp_query;
    $total_pages = $wp_query->max_num_pages;

    if( $total_pages === 1 ) {
        return [];
    }

    $page_number = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

    // get the self_link of the feed (WP will only print, not return this value, hence output buffer)
    ob_start();
    self_link();
    $self_link = ob_get_clean();

    /**
     *  x_query_arg should be escaped:
     *  https://make.wordpress.org/plugins/2015/04/20/fixing-add_query_arg-and-remove_query_arg-usage/
     *
     *  self_link already calls it, though, so there's no need here.
     */
    $feed_path = remove_query_arg( 'paged', $self_link );

    $pagination_options = [
        'first_page_href' => add_query_arg( 'paged', 1, $feed_path ),
        'last_page_href' => add_query_arg( 'paged', $total_pages, $feed_path ),
    ];
    if( $page_number > 1 ) {
        $pagination_options['previous_page_href'] = add_query_arg( 'paged', $page_number - 1, $feed_path );
    }
    if( $page_number < $total_pages ) {
        $pagination_options['next_page_href'] = add_query_arg( 'paged', $page_number + 1, $feed_path );
    }

    return $pagination_options;
}
