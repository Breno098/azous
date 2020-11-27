<?php

namespace Azuos\Http;

class Response
{
    private $format;
    
    public function error()
    {
        $this->code(400);
        return $this;
    }

    public function json()
    {
        $this->format = 'json';
        return $this;
    }

    /**
     * @param int $code 
     */
    public function code(int $code)
    {
        http_response_code($code);
        return $this;
    }

    /**
     * @param mixed $response 
     */
    public function send($response)
    {
        echo $this->format === 'json' ? json_encode($response, JSON_UNESCAPED_UNICODE) : var_dump($response);
    }

}