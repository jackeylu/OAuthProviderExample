<?php

// SERVER PROVIDER URL
$SERVER_URL		= "http://192.168.127.149/OAuthProviderExample";
$SERVER_OAUTH_URL	= $SERVER_URL . "/oauth";
$SERVER_LOGIN_URL	= $SERVER_OAUTH_URL. "/login.php";
$REQUEST_TOKEN_URL	= $SERVER_OAUTH_URL . "/?request_token";
$AUTHENTIFICATION_URL	= $SERVER_OAUTH_URL . "/login.php";
$ACCESS_TOKEN_URL	= $SERVER_OAUTH_URL . "/?access_token";

// CLIENT URL
$CLIENT_URL		= "http://192.168.127.129/OAuthClient/client";
$CALLBACK_URL		= $CLIENT_URL . "/callback.php";

// Client key and secret
// 从Service Provider (SERVER) 端注册应用时会分配得到
$CONSUMER_KEY		= "key";
$CONSUMER_SECRET	= "secret";

// API URL
//
// the base url
$API_SERVER_URL		= $SERVER_OAUTH_URL . "/?api";
// The url to get the user id with given access token
$API_USER_ID_URL	= $API_SERVER_URL . "/user";
// The url to get the gpa data with the given access token
$API_USER_GPA_URL	= $API_SERVER_URL . "/gpa";

?>
