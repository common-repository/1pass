<?php

class OnepassParamsTest extends WP_UnitTestCase {

	function testOnepassGetParams() {
        $this->setCredentials();
        $user_id = $this->factory->user->create();

        $post = $this->factory->post->create_and_get([
            'post_title' => 'My post',
            'post_content' => 'This is the content',
            'post_author' => $user_id
        ]);
        $params = onepass_get_params( $post );

        $required_params = [
            'url',
            'title',
            'unique_identifier',
            'ts',
            'publishable_key',
            'hash',
            'author_name'
        ];

        foreach( $required_params as $param ) {
            $this->assertTrue( isset( $params[$param] ) );
        }
	}

    function testOnepassAuthorFilter() {
        $post = $this->factory->post->create_and_get();

        add_filter( 'onepass_get_author', function() { return 'name'; } );        
        $params = onepass_get_params( $post );

        $this->assertEquals( 'name', $params['author_name'] );
	}

    function testOnepassTitleFilter() {
        $post = $this->factory->post->create_and_get();

        add_filter( 'onepass_get_title', function() { return 'title'; } );
        $params = onepass_get_params( $post );

        $this->assertEquals( 'title', $params['title'] );
	}

    private function setCredentials() {
        $live_credentials = [
            'publishable_key' => 'live_pub',
            'secret_key' => 'live_secret'
        ];
        update_option( 'onepass_live_credentials', $live_credentials );
    }

}
