<?php

class ActivationTest extends WP_UnitTestCase {

	function testEnableAllPostsFor1Pass() {
		$post_ids = $this->factory->post->create_many( 100 );
		onepass_enable_all_posts();
		shuffle($post_ids);
		$sample = array_slice( $post_ids, 0, 20 );

		foreach( $sample as $s ) {
			$this->assertTrue(is_onepass($s));
		}
	}

}
