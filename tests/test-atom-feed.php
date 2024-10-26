<?php

use PicoFeed\Reader\Reader;

class AtomFeedTest extends WP_UnitTestCase {

    function testFeedContainsOnepassContent() {
        $post = $this->factory->post->create();
        $this->markForOnepass( $post );

        $feed = $this->load_feed();

        $this->assertEquals( 1, count( $feed->getItems() ) );
	}

    function testFeedOnlyContainsOnepassContent() {
        $post = $this->factory->post->create();

        $feed = $this->load_feed();

        $this->assertEquals( 0, count( $feed->getItems() ) );
    }

	function testFeedContainsAll1PassPostsIrrespectiveOfPostType() {
		register_post_type( 'cpt',
			array(
				'labels' => array(
					'name' => 'CPs',
					'singular_name' => 'CP'
				),
				'public' => true,
				'capability_type' => 'post',
			)
		);
		$post = $this->factory->post->create( ['post_type' => 'cpt'] );
		$this->markForOnepass( $post );

		$feed = $this->load_feed();

		$this->assertEquals( 1, count( $feed->getItems() ) );
	}

    function testFeedComesInOrderOfRecency() {
        $old_post = $this->factory->post->create( [
            'post_title' => 'old',
            'post_date' => '2000-10-21 10:00:00'
        ] );
        $this->markForOnepass( $old_post );
        $new_post = $this->factory->post->create( [
            'post_title' => 'new',
            'post_date' => '2010-10-21 10:00:00'
        ] );
        $this->markForOnepass( $new_post );

        $feed = $this->load_feed();
        $items = $feed->getItems();

        // new post comes first
        $this->assertEquals( $items[0]->title, 'new' );
        $this->assertEquals( $items[1]->title, 'old' );
    }

    function testFeedComesInOrderOfModification() {
        $old_post = $this->factory->post->create( [
            'post_title' => 'old',
            'post_date' => '2000-10-21 10:00:00'
        ] );
        $this->markForOnepass( $old_post );
        $new_post = $this->factory->post->create( [
            'post_title' => 'new',
            'post_date' => '2010-10-21 10:00:00'
        ] );
        $this->markForOnepass( $new_post );

        wp_update_post( [
            'ID' => $old_post,
            'post_title' => 'old_modified'
        ] );

        $feed = $this->load_feed();
        $items = $feed->getItems();

        // old post comes first
        $this->assertEquals( $items[0]->title, 'old_modified' );
        $this->assertEquals( $items[1]->title, 'new' );
    }

    function testGuidsAreUnescapedInFeed() {
        $post = $this->factory->post->create( [
            'post_title' => 'new',
            'post_date' => '2010-10-21 10:00:00',
            'guid' => 'http://example.com/?foo=1&bar=2'
        ] );
        $this->markForOnepass( $post );

        $feed = $this->load_feed();
        $items = $feed->getItems();

        $id_in_feed = (string) $items[0]->xml->id;

        // if escaped, ampersand would be &amp;
        $this->assertEquals( 'http://example.com/?foo=1&bar=2', $id_in_feed );
    }

    private function load_feed() {
        onepass_initialise_atom_feed();
        add_action( 'onepass_authenticate', '__return_true' ); // skip authentication
        query_posts( 'feed=onepass&1pass=1pass' ); // run the query so the feed populates

        ob_start();
        onepass_render_feed();
        $feed = ob_get_clean();

        $reader = new Reader();
        $parser = $reader->getParser( '', $feed, 'UTF-8' );

        return $parser->execute();
    }

    private function markForOnepass( $post ) {
        wp_set_object_terms( $post, '1pass', '1pass' );
    }

}
