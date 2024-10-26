<?php

class AuthenticationTest extends WP_UnitTestCase {

	function testOnepassAuthenticateValid() {
		$url = "https://example.com/feed/atom/1pass/";

		$timestamp = time();
		$hash = onepass_build_hash( $url, $timestamp );

		$request_params = [
			'HTTP_X_1PASS_SIGNATURE' => $hash,
			'HTTP_X_1PASS_TIMESTAMP' => $timestamp,
			'SERVER_PORT' => 443,
			'HTTP_HOST' => 'example.com',
			'REQUEST_URI' => '/feed/atom/1pass'
		];

		$this->assertTrue( onepass_authenticate( $request_params ) );
	}

	function testOnepassAuthenticateInvalid() {
		$request_params = [
			'HTTP_X_1PASS_SIGNATURE' => 'invalid',
			'HTTP_X_1PASS_TIMESTAMP' => 1234,
			'SERVER_PORT' => 443,
			'HTTP_HOST' => 'example.com',
			'REQUEST_URI' => '/feed/atom/1pass'
		];
		$this->assertFalse( onepass_authenticate( $request_params ) );
	}


	function testOnePassGetTheGuid() {
		// Create a post whose GUID contains an ampersand that will be escaped
		// when it hits the database
		$guid = 'http://example.com/?foo=1&bar=2';
		$p = $this->factory->post->create_and_get(['guid' => $guid]);

		// assert normal get_the_guid reads the changed version
		$this->assertEquals( 'http://example.com/?foo=1&amp;bar=2', get_the_guid( $p ) );

		// assert onepass_get_the_guid fixes it on the way out
		$this->assertEquals( 'http://example.com/?foo=1&bar=2', onepass_get_the_guid( $p ) );
	}
}
