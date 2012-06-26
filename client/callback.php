<?php
	if(isset($_REQUEST['oauth_token'])&&isset($_REQUEST['oauth_verifier'])){
		if(isset($_POST['oauth_token'])){
			try{
				$oauth_client = new Oauth("key","secret");
				$oauth_client->enableDebug();
				$oauth_client->setToken($_POST['oauth_token'],$_POST['oauth_token_secret']);
				$info = $oauth_client->getAccessToken("http://192.168.127.149/OAuthProviderExample/oauth/?access_token",null,$_POST['oauth_verifier']);
				print_r($info);
				echo "<h1>Congrats !</h1>";
				echo "<strong>AccessToken</strong> ".$info['oauth_token']."<br />";
				echo "<strong>AccessToken Secret</strong> ".$info['oauth_token_secret'];
				echo "<a href=\"apicall.php?token=".$info['oauth_token']."&token_secret=".$info['oauth_token_secret']."\">get your user id with an api call</a>";
			} catch(OAuthException $E){
				echo "<strong>" . $E->getMessage() . "</strong>";
				echo "<br/>debug information : <br/>";
				var_dump($E->debugInfo);
				echo "<br/>";
			}
			
			
		} else {
		?>
			<form method="post" action="callback.php">
				<label>token</label>
				<input type="text" name="oauth_token" value="<?php echo $_REQUEST['oauth_token'];?>" /><br />
				<label>secret</label>
				<input type="text" name="oauth_token_secret" value="" />
				<span>This is not passed by url, a real client would have stored this somewhere, you can get it from the db</span>
				<br />
				<label>verifier</label>
				<input type="text" name="oauth_verifier" value="<?php echo $_REQUEST['oauth_verifier']?>" />
				<input type="submit" value="OK">
			</form>
		<?php
		}
	}
	else{
		echo "<strong> this is failed with empty token.</strong>";
	}
?>
