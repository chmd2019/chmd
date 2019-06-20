<?php
session_start(); //session start
//include_once("Model/DBManager.php");
require_once('../../libraries/Google/autoload.php');
require_once '../../Model/Config.php';
require_once '../../Model/Login.php';
//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
    unset($_SESSION['access_token']);
}
$service = new Google_Service_Oauth2($client);
//echo "$service";
if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
    exit;
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
} else {
    $authUrl = $client->createAuthUrl();
}
?>