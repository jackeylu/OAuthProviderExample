<?php
	$oauth_client = new Oauth("key","secret");
	$oauth_client->enableDebug();
	try {
		$info = $oauth_client->getRequestToken("http://192.168.127.149/OAuthProviderExample/oauth/?request_token&oauth_callback=http://192.168.127.149/OAuthProviderExample/client/callback.php");
		if (FALSE == $info || !isset($info) || empty($info))
		{
			print "Failed fetching request token, response was:".
				$oauth_client->getLastResponse();
			exit(1);
		}
		echo "<h1>We have a request token !</h1>";
		echo "<strong>Request token</strong> : ".$info['oauth_token']."<br />";
		echo "<strong>Request token secret</strong> : ".$info['oauth_token_secret']."<br />";
		echo "to authenticate go <a href=\""."http://192.168.127.149/OAuthProviderExample/oauth/login.php"."?oauth_token=".$info['oauth_token']."\">here</a>";
	} catch(OAuthException $E){
		echo "<pre>OAuthException occured.</pre>";
		echo "<pre>". $E->getMessage() . "</pre>";
		echo "<pre>".print_r($E->getTrace(),true)."</pre>";
		echo "<pre>".print_r($E->debugInfo,true)."</pre>";
	}
?>
