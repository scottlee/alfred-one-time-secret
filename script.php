<?php
/**
 * Share information securely using the One-Time Secret service.
 *
 * @author scottlee
 * @link https://github.com/scottlee/alfred-one-time-secret
 *
 * @license GNU
 * @license https://github.com/scottlee/alfred-one-time-secret/blob/master/LICENSE
 *
 * @uses OneTimeSecret
 * @link https://onetimesecret.com/
 */

// Include the API Helper
include( 'onetime-api.php' );

// Bail if the API authentication is missing
$customer_id = ( isset( $argv[1] ) ) ? trim( $argv[1] ) : '';
$API_Key     = ( isset( $argv[2] ) ) ? trim( $argv[2] ) : '';

if ( empty( $customer_id ) || empty( $API_Key ) ) {
	die( 'Missing customer ID (email) or API key.' );
}

// Friendly var names
$query     = explode( '|', $argv[3] );
$secret    = ( isset( $query[0] ) ) ? trim( $query[0] ) : '';
$pass      = ( isset( $query[1] ) ) ? trim( $query[1] ) : '';
$recipient = ( isset( $query[2] ) ) ? trim( $query[2] ) : false;


// Start it up
$myOnetime = new OneTimeSecret;
$myOnetime->setCustomerID( $customer_id );
$myOnetime->setToken( $API_Key );
$myOnetime->setTTL( 3600 );

// Are we notifying anyone directly?
if ( $recipient ) {
	$myOnetime->setRecipient( $recipient );
}

// (doit)
$myResult = $myOnetime->shareSecret( $secret, $pass );
echo $myOnetime->getSecretURI( $myResult );