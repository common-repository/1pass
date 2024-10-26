<?php

class ContentRestrictionTest extends WP_UnitTestCase {

	function testIsOnePass() {
        $onepass_post = $this->factory->post->create();
        $this->markForOnepass( $onepass_post );

        $non_onepass_post = $this->factory->post->create();

        $this->assertTrue( is_onepass( $onepass_post ) );
        $this->assertFalse( is_onepass( $non_onepass_post ) );
    }

    function testRestrictionRules() {
        $post = $this->factory->post->create();
		
        add_filter( 'onepass_restrictions', '__return_true' ); // will restrict everything
        $this->assertTrue( onepass_restrict_post( $post ) );

		add_filter( 'onepass_restrictions', '__return_false' ); // will restrict everything
        $this->assertFalse( onepass_restrict_post( $post ) );
    }

    /**
     * When a post is truncated the [1pass] shortcode is replaced with
     * [_1pass] in the post content. The content should end there.
     */
	function testTruncation() {
		$post = $this->factory->post->create_and_get([
            'post_content' => 'This is my post <!--more--> here is the rest'
        ]);
        onepass_truncate_post( $post );
        $this->assertTruncated( $post->post_content );

		$post = $this->factory->post->create_and_get([
			'post_content' => 'This is my post, here is the rest'
		]);
		onepass_truncate_post( $post );
		$this->assertNotTruncated( $post->post_content );
	}

    private function markForOnepass( $post ) {
        wp_set_object_terms( $post, '1pass', '1pass' );
    }

    private function assertTruncated( $content ) {
        $this->assertRegexp('/\[_1pass\]$/', $content );
    }

    private function assertNotTruncated( $content ) {
        $this->assertNotRegexp('/\[_1pass\]$/', $content );
    }
}
