<?php

namespace Azuos\Http;

class Request
{
    private $method;
    private $host;
    private $uri;
    private $link;
    public $params = [];
    
    /**
     * @param array $params Parametos para criação do objeto de requisição
     */
    public function __construct(array $params)
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? null;
        $this->host = $_SERVER['HTTP_HOST'] ?? null;
        $this->uri = $_SERVER['REQUEST_URI'] ?? null;
        $this->link = $this->host . $this->uri;
        $this->createRequest($params);
    }

    /**
     * @param array $params Criação dos parametros
     */
    private function createRequest(array $params)
    {
        foreach ($params as $key => $value){
            $this->addParam($key, $value);
            if( $value = \json_decode($value)){
                $this->addParam($key, $value);
                // foreach ( $value as $keyJson => $valueJson){
                //     $this->addParam($keyJson, $valueJson);
                // }
            } 
        }
    }

    /**
     * @param string $attribute
     * @param mixed $value
     */
    private function addParam(string $attribute, $value)
    {
        $this->$attribute = $value;
        $this->params[$attribute] = $value;
    }
}