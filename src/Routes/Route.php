<?php

namespace Azous\Routes;

use Azous\Tools\TArray;
use Azous\Http\Request;

class Route 
{
    private $method;
    private $callBack;
    private $parsedPath = [];
    private $params = [];
    private $auth;
    
    /**
     * @param string $method Metodo da requisição
     * @param string $path Caminho da rota
     * @param string $callBack Controller e função: $callBack = '{Controlller}@{function}'
     */
    public function __construct(string $method, string $path, string $callBack)
    {
        $this->setMethod($method);
        $this->setCallback($callBack);
        $this->setPath($path);
    }

    /**
     * @param string $path Caminho da rota
     */
    private function setPath(string $path)
    {
        $str_explode = explode('/', $path);
        foreach ($str_explode as $key => $value) {
            preg_match('/{(.*?)}/', $value, $matches);
            if($matches){
                $this->parsedPath[] = array(
                    'nameParam' => $matches[1],
                    'value' => '*'
                );
            } else {
                $this->parsedPath[] = array(
                    'nameParam' => false,
                    'value' => $value
                );
            }
        }
    }

    /**
     * @param string $callBack Controller e função: $callBack = '{Controlller}@{function}'
     */
    private function setCallback(string $callBack)
    {
        $this->callBack = TArray::explode('@', $callBack, [ 'class', 'function' ]);
    }

    /**
     * @param string $method Metodo da requisição
     */
    private function setMethod(string $method)
    {
        $this->method = strtoupper($method);
    }

    /**
     * @param string $param Parametro da rotas
     * @param mixed $value Valor para o parametro
     */
    private function addParam(string $param, $value)
    {
        $this->params[$param] = $value;
    }

    /**
     * @return bool
     */
    private function processReqMethod()
    {
        return $_SERVER['REQUEST_METHOD'] === $this->method;
    }

    /**
     * @return bool
     */
    private function processUrl()
    {
        $url = explode('/', $_SERVER['REQUEST_URI'] ?? '/');
        if( !(count($this->parsedPath) === count($url))  ){
            return false;
        }
        $pos = 0;
        foreach ($this->parsedPath as $parsed) {
            if($parsed['value'] === '*'){
                $this->addParam($parsed['nameParam'], $url[$pos]);
            } else if($parsed['value'] !== $url[$pos]){
                return false;
            }
            $pos++;
        }
        return true;
    }

    private function parserVariablesPost()
    {
        if($this->method === "POST"){
            foreach ($_REQUEST as $key => $value) {
                $this->addParam($key, $value);
            }
        }
    }

    /**
     * @return bool
     */
    public function verify()
    {
        return $this->processReqMethod() && $this->processUrl();
    }

    /**
     * @return string
     */
    private function mounted($request)
    {
        $use = "\\Azous\\Controller\\";
        $class = $use . $this->callBack['class'];
        $function = $this->callBack['function'];
        return (new $class)->$function($request);
    }

    /**
     * @return mixed
     */
    public function run()
    {
        $this->parserVariablesPost();
        $request = new Request($this->params);
        return $this->verifyAuth($request) ? $this->mounted($request) : $this->notAuth();
    }

    private function notAuth()
    {
        response()->json()->code(401)->send([ 
            'status' => 'not auth',
            'code' => '401'
        ]);
    }

    public function auth($token = '')
    {
        $this->auth['enabled'] = true;
        if(!empty($token)){
            $this->auth['type'] = 'token';
            $this->auth['token'] = $token;
        } else {
            $this->auth['type'] = 'env';
        }
    }

    private function verifyAuth(Request $request)
    {
        if(isset($this->auth['enabled'])){
            if(isset($request->auth)){
                if($this->auth['type'] === 'env'){
                    return $request->auth === env('AUTH_API');
                } 
                if($this->auth['type'] === 'token'){
                    if(\is_array($this->auth['token'])){
                        if(isset($this->auth['token'][0])){
                            foreach ($this->auth['token'] as $array) {
                               if(in_array($request->auth, $array)){
                                    return true;
                               }
                            }
                        }
                        return in_array($request->auth, $this->auth['token']);
                    } else {
                        return $request->auth == $this->auth['token'];
                    }
                } 
            }
            return false;
        }
        return true;
    }

}