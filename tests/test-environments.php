<?php

class EnvironmentsTest extends WP_UnitTestCase {

	function testLiveEnvironmentSettings() {
        update_option( 'onepass_environment', 'live' );
        onepass_set_environment();

        $this->assertEquals( onepass_get_onepass_domain(), 'https://1pass.me' );
        $this->assertFalse( onepass_is_test_environment() );
	}

    function testTestEnvironmentSettings() {
        update_option( 'onepass_environment', 'test' );
        onepass_set_environment();

        $this->assertEquals( onepass_get_onepass_domain(), 'https://demo.1pass.me' );
        $this->assertTrue( onepass_is_test_environment() );
	}

}
