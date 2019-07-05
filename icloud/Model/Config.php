<?php

$client_id = '144850677714-c4plqe32kmrg8ablofs972e814vvg3b5.apps.googleusercontent.com';
$client_secret ='A652r3j7R99tTFpPKNpFjAzH';
$redirect_uri = 'https://www.chmd.edu.mx/pruebascd/icloud/';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
