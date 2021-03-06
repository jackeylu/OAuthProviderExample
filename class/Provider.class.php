<?php

	class Provider{
		
		private $oauth;
		private $consumer;
		private $oauth_error;
		private $user;
		private $authentification_url = "http://192.168.127.149/OAuthProviderExample/oauth/login.php";
		
		public static function createConsumer(){
			$key = sha1(OAuthProvider::generateToken(20));
			$secret = sha1(OAuthProvider::generateToken(20));
			return Consumer::create($key,$secret);
		}
		
		public function __construct(){
			
			/* create our instance */
			$this->oauth = new OAuthProvider();
			
			/*
			 * 关键的步骤，注册必须的三个handler
			 */
			/* setup check functions */
			$this->oauth->consumerHandler(array($this,'checkConsumer'));
			$this->oauth->timestampNonceHandler(array($this,'checkNonce'));
			$this->oauth->tokenHandler(array($this,'checkToken'));
			
		}
		
		/**
		 * This function check the handlers that we added in the constructor
		 * and then checks for a valid signature
		 */
		public function checkRequest(){
			/* now that everything is setup we run the checks */
			try{
				/*
				 * 该过程将会调用在__construct中注册的
				 * 三个handlers
				 */
				$this->oauth->checkOAuthRequest();
			} catch(OAuthException $E){
				echo OAuthProvider::reportProblem($E);
				$this->oauth_error = true;
			}
		}
		
		/**
		 * This function is called when you are requesting a request token
		 * Basicly it disabled the tokenHandler check and force the oauth_callback parameter
		 */
		public function setRequestTokenQuery(){
			$this->oauth->isRequestTokenEndpoint(true); 
			$this->oauth->addRequiredParameter("oauth_callback");
		}
		
		/**
		 * This function generates a Request token
		 * and save it in the db
		 * then returns the oauth_token, oauth_token_secret & the authentification url
		 * Please note that the authentification_url is not part of the oauth protocol but I added it to show you how to add extra parameters
		 */
		public function generateRequestToken(){
			
			if($this->oauth_error){
				return false;
			}
			
			$token = sha1(OAuthProvider::generateToken(20));
			$token_secret = sha1(OAuthProvider::generateToken(20));
			
			$callback = $this->oauth->callback;
			
			Token::createRequestToken($this->consumer, $token, $token_secret, $callback);
		
			return "authentification_url=".$this->authentification_url."&oauth_token=".$token."&oauth_token_secret=".$token_secret."&oauth_callback_confirmed=true";
			
		}
		
		/**
		 * This function generates a Access token saves it in the DB and return it
		 * In that process it also removes the request token used to get that access token
		 *
		 * 调用该方法之前，应该先调用 checkRequest方法
		 */
		public function generateAccesstoken(){
			
			if($this->oauth_error){
				return false;
			}
			
			/*
			 * 注意，尽量不要在OAuthProvider::generateToken参数中
			 * 将$strong参数设置成true，否则可以导致超时，
			 * 引起数据库或http的time out等难以定位的问题
			 */
			$access_token = sha1(OAuthProvider::generateToken(20));
			$secret = sha1(OAuthProvider::generateToken(20));
			
			/*
			 * 生成一对令牌后，要写入到数据库，以备后用
			 *
			 * 首先，要保证数据库中的令牌不重复
			 */
			$token = Token::findByToken($this->oauth->token);
			
			$token->changeToAccessToken($access_token,$secret);
			return "oauth_token=".$access_token."&oauth_token_secret=".$secret;
		}
		
		/**
		 * This function generates a verifier and returns it
		 */
		public function generateVerifier(){
			$verifier = sha1(OAuthProvider::generateToken(20));
			return $verifier;
		}
		
		/* handlers */
		
		/**
		 * This function checks if the consumer exist in the DB and that it is active
		 * You can modify it at your will but you __HAVE TO__ set $provider->consumer_secret to the right value or the signature will fail
		 * It's called by OAuthCheckRequest()
		 * @param $provider
		 */
		public function checkConsumer($provider){
			$return = OAUTH_CONSUMER_KEY_UNKNOWN;
			
			$aConsumer = Consumer::findByKey($provider->consumer_key);
			
			if(is_object($aConsumer)){
				if(!$aConsumer->isActive()){
					$return = OAUTH_CONSUMER_KEY_REFUSED;
				} else {
					$this->consumer = $aConsumer;
					$provider->consumer_secret = $this->consumer->getSecretKey();
					$return = OAUTH_OK;
				}
			}
			
			return $return;
		}
		
		/**
		 * This function checks the token of the client
		 * Fails if token not found, or verifier not correct
		 * Once again you __HAVE TO__ set the $provider->token_secret to the right value or the signature will fail
		 * It's called by OAuthCheckRequest() unless the client is getting a request token
		 * @param unknown_type $provider
		 */
		public function checkToken($provider){
			$token = Token::findByToken($provider->token);
			
			if(is_null($token)){ // token not found
				return OAUTH_TOKEN_REJECTED;
			} elseif($token->getType() == 1 && $token->getVerifier() != $provider->verifier){ // bad verifier for request token
				return OAUTH_VERIFIER_INVALID;
			} else {
				if($token->getType() == 2){
					/* if this is an access token we register the user to the provider for use in our api */
					$this->user = $token->getUser();
				}
				$provider->token_secret = $token->getSecret();
				return OAUTH_OK;
			}
			
		}
		
		/**
		 * This function check both the timestamp & the nonce
		 * The timestamp has to be less than 5 minutes ago (this is not oauth protocol so feel free to change that)
		 * And the nonce has to be unknown for this consumer
		 * Once everything is OK it saves the nonce in the db
		 * It's called by OAuthCheckRequest()
		 *
		 * 此处设定的是timestamp不能超过5分钟，否则失效
		 *
		 * 如果参数中的nonce变量在数据库中已经存在，则是非法的nonce值
		 * 否则，将该nonce值插入到数据库中
		 * @param $provider
		 */
		public function checkNonce($provider){
			if($this->oauth->timestamp < time() - 5*60){
				return OAUTH_BAD_TIMESTAMP;
			} elseif($this->consumer->hasNonce($provider->nonce,$this->oauth->timestamp)) {
				return OAUTH_BAD_NONCE;
			} else {
				$this->consumer->addNonce($this->oauth->nonce);
				return OAUTH_OK;
			}
		}
		
		public function getUser(){
			if(is_object($this->user)){
				return $this->user;
			} else {
				throw new Exception("User not authentificated");
			}
		}
		
	}
?>
