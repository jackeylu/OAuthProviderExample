<?php

// SERVER PROVIDER URL
$SERVER_URL		= "http://192.168.127.149/OAuthProviderExample";
$SERVER_OAUTH_URL	= $SERVER_URL . "/oauth/";
$SERVER_LOGIN_URL	= $SERVER_LOGIN_URL . "/login.php";
$REQUEST_TOKEN_URL	= $SERVER_URL . "/?request_token";
$AUTHENTIFICATION_URL	= $SERVER_URL . "/login.php";
$ACCESS_TOKEN_URL	= $SERVER_URL . "/?access_token";

// CLIENT URL
$CLIENT_URL		= "http://192.168.127.129/OAuthClient/client";
$CALLBACK_URL		= $CLIENT_URL . "/callback.php";

// API URL
//
// the base url
$API_SERVER_URL		= $SERVER_OAUTH_URL . "?/api";
// The url to get the user id with given access token
$API_USER_ID_URL	= $API_SERVER_URL . "/user";
// The url to get the gpa data with the given access token
$API_USER_GPA_URL	= $API_SERVER_URL . "/gpa";

?>