<?php

namespace RodrigoRigotti\Api;

use Guzzle\Http\Client;

class OlhoVivo
{
    /** @var Client $client */
    private $client;
    
    private $apiCredentials;
    private $token;
    
    public function __construct($token)
    {
        if (!preg_match('/^([0-9a-f]{64})$/', $token)) {
            throw new \Exception('Invalid token format.');
        }
        $this->token  = $token;
        $this->client = new Client('http://api.olhovivo.sptrans.com.br/v0');
        $this->authorize();
    }
    
    public function getLinhas($termosBusca)
    {
        $request = $this->client->get('Linha/Buscar');
        $request->addCookie('apiCredentials', $this->apiCredentials);
        $request->getQuery()->set('termosBusca', $termosBusca);
        $response = $request->send();
        return $response->json();
    }
    
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
    
    public function setToken($token)
    {
        $this->token = $token;
        $this->authorize();
    }
    
    private function authorize()
    {
        if (!$this->client instanceof Client) {
            throw new \Exception('Authorization process called prematurely.');
        }
        if (!$this->token) {
            throw new \Exception('Token not informed.');
        }
        $authorization = $this->client->post('Login/Autenticar?token='.$this->token)->send();
        if (false === (boolean)$authorization->getBody()) {
            throw new \Exception('Authorization did not succeed.');
        }
        preg_match('/^apiCredentials=(\w+)/', $authorization->getSetCookie(), $match);
        $this->apiCredentials = $match[1];
    }
}