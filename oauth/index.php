<?php
function __autoload($name){
	require("../class/".$name.".class.php");
}



if (isset($_REQUEST['oauth_token'])){
	$request_token = Token::findByToken($_REQUEST['oauth_token']);
	if(is_object($request_token) && $request_token->isRequest()){
		if(!isset($_POST['login'])){
?>

	<form method=post>
		<lable>Login: </lable>
		<input type="text" name="login" /><br/>
		<input type="submit" value="Authenticate to this website"/>
	</form>
<?php
		}else
		{
			$user=User::exist($_POST['login']);
			if(is_object($user)){
				$request_token->setVerifier(Provider::getnerateVerifier());
				$request_token->setUser($user);
				header("location: ".$request_token->getCallback()."?&oauth_token=".$_REQUEST['oauth_token']."&oauth_verifier=".$request_token->getVerifier());
			}else{
				echo "User not found !";
			}
		}
	}else{
		echo "Please specify an oauth_token";
	}
}else{
	echo "Invalid parameter called";
}

/*	$provider = new Provider();

	if(strstr($_SERVER['REQUEST_URI'],"request_token")){
		echo "request_token:";
		$provider->setRequestTokenQuery();
		$provider->checkRequest();
		echo $provider->generateRequestToken();
	} else if(strstr($_SERVER['REQUEST_URI'],"access_token")){
		echo "access_token:";
		$provider->checkRequest();
		echo $provider->generateAccessToken();
	} else if(strstr($_SERVER['REQUEST_URI'],"create_consumer")){
		echo "create_consumer:";
		$consumer = Provider::createConsumer();
		?>
		<h1>New consumer</h1>
		<strong>Key : </strong> <?php echo $consumer->getKey()?><br />
		<strong>Secret : </strong> <?php echo $consumer->getSecretKey()?>
		<?php
	} else if(strstr($_SERVER['REQUEST_URI'],"api/user")){
		// this is a basic api call that will return the id of an authenticated user 
		$provider->checkRequest();
		try {
			echo $provider->getUser()->getId();
		} catch(Exception $E){
			echo "Exception occured: ";
			echo $E;
		}
	}
	else{
		echo "give some parameters, OK?";
	}

 */ 
?>
