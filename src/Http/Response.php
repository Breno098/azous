<?php

namespace Azous\Http;

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
     * @param int $code Código da resposta
     */
    public function code(int $code)
    {
        http_response_code($code);
        return $this;
    }

    /**
     * @param mixed $response Dados a serem enviados
     */
    public function send($response)
    {
        echo $this->format === 'json' ? json_encode($response) : var_dump($response);
    }

}