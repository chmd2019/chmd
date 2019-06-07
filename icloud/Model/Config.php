<?php

$client_id = '144850677714-m6026buduis4id443pjcvmk31ceu8e3i.apps.googleusercontent.com';
$client_secret ='CsqLEfWCKZRH7egeKkXhZyn6';
$redirect_uri = 'https://www.chmd.edu.mx/pruebas/icloud';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");
