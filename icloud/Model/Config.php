<?php

/*$client_id = '144850677714-ghn8l55tdb3jr0phsgcgg8fdk8435dpn.apps.googleusercontent.com';
$client_secret ='RFuajea3D6BwQeng2eWgdwFv';
$redirect_uri = 'http://esteticashirley.com/icloud/';*/

$client_id = '144850677714-qbl5vkn02todusjsg52cgrgun9rf8km3.apps.googleusercontent.com';
$client_secret ='B7B6-lNw0mQrIRzkLU6E5Znq';
$redirect_uri = 'https://www.chmd.edu.mx/pruebas/icloud/';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
