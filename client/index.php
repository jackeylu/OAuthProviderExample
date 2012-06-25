<?php
	$oauth_client = new Oauth("key","secret");
	$oauth_client->enableDebug();
	try {
		$info = $oauth_client->getRequestToken("http://www.oape.net/oauth/?request_token&oauth_callback=http://www.oape.net/client/callback.php");
		print_r($info);
		if (FALSE == $info || !isset($info) || empty($info))
		{
			print "Failed fetching request token, response was:".
				$oauth_client->getLastResponse();
			exit(1);
		}
		echo "<h1>We have a request token !</h1>";
		echo "<strong>Request token</strong> : ".$info['oauth_token']."<br />";
		echo "<strong>Request token secret</strong> : ".$info['oauth_token_secret']."<br />";
		echo "to authenticate go <a href=\"".$info['authentification_url']."?oauth_token=".$info['oauth_token']."\">here</a>";
	} catch(OAuthException $E){
		echo "<pre>OAuthException occured.</pre>";
		echo "<pre>". $E->getMessage() . "</pre>";
		echo "<pre>".print_r($E->getTrace(),true)."</pre>";
		echo "<pre>".print_r($E->debugInfo,true)."</pre>";
	}
?>
