<?php
	$oauth_client = new Oauth("key","secret");
	$oauth_client->enableDebug();
	try {
		$info = $oauth_client->getRequestToken($REQUEST_TOKEN_URL . "&oauth_callback=" . $CALLBACK_URL);
		if (FALSE == $info || !isset($info) || empty($info))
		{
			print "Failed fetching request token, response was:".
				$oauth_client->getLastResponse();
			exit(1);
		}
		echo "<h1>We have a request token !</h1>";
		echo "<strong>Request token</strong> : ".$info['oauth_token']."<br />";
		echo "<strong>Request token secret</strong> : ".$info['oauth_token_secret']."<br />";
		echo "to authenticate go <a href=\"".$SERVER_LOGIN_URL."?oauth_token=".$info['oauth_token']."\">here</a>";
	} catch(OAuthException $E){
		echo "<pre>OAuthException occured.</pre>";
		echo "<pre>". $E->getMessage() . "</pre>";
		echo "<pre>".print_r($E->getTrace(),true)."</pre>";
		echo "<pre>".print_r($E->debugInfo,true)."</pre>";
	}
?>
