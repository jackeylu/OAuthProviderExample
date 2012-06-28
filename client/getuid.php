<?php
require_once(dirname(__FILE__) . "/config.php");

/*
 * An example for a given user id (1:1 with access token)
 */
$access_token		= '8cc17dc4f26f78c18699f0bbccd16f3b5e232811';
$access_token_secret	= '1c0a400a911574dec8ac7d8f594904aadd6fda17';

try{
	$oauth_client  = new Oauth($CONSUMER_KEY,
					$CONSUMER_SECRET);
	$oauth_client->enableDebug();
	$oauth_client->setToken($access_token,
			$access_token_secret);
	$oauth_client->fetch($API_USER_ID_URL);
	echo "user id with given access token $access_token is : " . $oauth_client->getLastResponse();
}catch(OAuthException $e){
	echo "get userid failed with an OAuthException: ";
	echo $e->getMessage();
	echo "<br/>";
	print_r($e->debugInfo);
}

?>
