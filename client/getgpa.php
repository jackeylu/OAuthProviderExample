<?php
require_once(dirname(__FILE__) . "/config.php");

$access_token		= '8cc17dc4f26f78c18699f0bbccd16f3b5e232811';
$access_token_secret	= '1c0a400a911574dec8ac7d8f594904aadd6fda17';

try{
	$oauth_client  = new Oauth($CONSUMER_KEY,
					$CONSUMER_SECRET);
//	$oauth_client->enableDebug();
	$oauth_client->setToken($access_token,
			$access_token_secret);
	$oauth_client->fetch($API_USER_GPA_URL);
	$response_info = $oauth_client->getLastResponseInfo();
	header("Content-Type: {$response_info["content_type"]}");
	echo $oauth_client->getLastResponse();
}catch(OAuthException $e){
	echo $e->getMessage();
}

?>
