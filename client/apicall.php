<?php
/*
 * An example to get the id of user from the API server
 *
 * by the access token/secret and consumer key/secret
 */

require_once(dirname(__FILE__) . "/config.php");

if(isset($_POST['token'])){
	try {
		$oauth_client = new Oauth("key","secret");
		$oauth_client->enableDebug();
		$oauth_client->setToken($_POST['token'],$_POST['token_secret']);
		$oauth_client->fetch($API_USER_ID_URL);
		echo "The id of User with the given access token is : ".$oauth_client->getLastResponse();
	} catch (OAuthException $E){
		echo $E->debugInfo;
	}
} else {
?>
	<form method="post">
		Access token : <input type="text" name="token" value="<?php echo $_REQUEST['token'];?>" /> <br />
		Access token secret : <input type="text" name="token_secret" value="<?php echo $_REQUEST['token_secret'];?>" /> <br />
		<input type="submit" value="do an api call" />
	</form>
<?php
}
?>
