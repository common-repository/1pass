<?php

class CredentialsTest extends WP_UnitTestCase {

    function testGetCredentials() {
        $live_credentials = [
            'publishable_key' => 'live_pub',
            'secret_key' => 'live_secret'
        ];

        $test_credentials = [
            'publishable_key' => 'test_pub',
            'secret_key' => 'test_secret'
        ];

        update_option( 'onepass_live_credentials', $live_credentials );
        update_option( 'onepass_test_credentials', $test_credentials );

        $this->assertEquals( $live_credentials, onepass_load_credentials( 'live' ) );
        $this->assertEquals( $test_credentials, onepass_load_credentials( 'test' ) );
    }

}
