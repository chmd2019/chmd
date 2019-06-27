<?php

class Config {
    public $client_id = '144850677714-c4plqe32kmrg8ablofs972e814vvg3b5.apps.googleusercontent.com';
    public $client_secret ='A652r3j7R99tTFpPKNpFjAzH';
    public $redirect_uri = 'https://www.chmd.edu.mx/pruebascd/icloud/';
    public $client;
    public function Config(){
        $this->client = new Google_Client();
        $this->client->setClientId($client_id);
        $this->client->setClientSecret($client_secret);
        $this->client->setRedirectUri($redirect_uri);
        $this->client->addScope("email");
        $this->client->addScope("profile");
    }
    
    public function client(){
        return $client;
    }

}
