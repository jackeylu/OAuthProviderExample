<?php
	$oauth_client = new Oauth("key","secret");
	$oauth_client->enableDebug();
	try {
		$info = $oauth_client->getRequestToken("http://www.oape.net/oauth/request_token?oauth_callback=http://www.oape.net/client/callback.php");
		echo "<h1>We have a request token !</h1>";
		echo "<strong>Request token</strong> : ".$info['oauth_token']."<br />";
		echo "<strong>Request token secret</strong> : ".$info['oauth_token_secret']."<br />";
		echo "to authenticate go <a href=\"".$info['authentification_url']."?oauth_token=".$info['oauth_token']."\">here</a>";
	} catch(OAuthException $E){
		echo "<pre>".print_r($E->debugInfo,true)."</pre>";
	}
?>
