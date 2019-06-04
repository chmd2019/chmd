<?php

$client_id = '';
$client_secret ='';
$redirect_uri = ''; 

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");


?>