<?php

use Onepass\Common\PublisherAccount;

/**
 * Default authentication — enable 1Pass to reach your content securely
 *
 * This function looks for x-1pass-signature and x-1pass-timestamp headers,
 * and expects to find a properly signed request.
 *
 * If you prefer to authenticate differently, you can filter the return value
 * of this function using 'onepass_authenticate'
 *
 * @return bool
 */
function onepass_authenticate( $server ) {
    // allow requests to URLs without the trailing slash to authenticate as well
    $server['REQUEST_URI'] = trailingslashit($server['REQUEST_URI']);

    $env = onepass_get_environment();
    $publisherAccount = new PublisherAccount(onepass_load_credentials( $env ));
    $authenticated = $publisherAccount->isAuthenticRequestFrom1Pass($server);

    return apply_filters( 'onepass_authenticate', $authenticated, $server );
}

/**
 * Build a hash we can use to authenticate with 1Pass
 * @return string
 */
function onepass_build_hash( $uniqueIdentifier, $ts ) {
    $env = onepass_get_environment();
    $publisherAccount = new PublisherAccount(onepass_load_credentials( $env ));
    return $publisherAccount->buildHash($uniqueIdentifier, $ts);
}
