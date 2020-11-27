<?php

namespace Azuos\Routes;

use Azuos\Tools\AzArr;
use Azuos\Http\Request;

class BaseRoute 
{
    private $method;
    private $callBack;
    private $parsedPath = [];
    private $params = [];
    private $auth;
    public $route;
    private $fixed = '/index.php';
    
    /**
     * @param string $method Metodo da requisição
     * @param string $path Caminho da rota
     * @param string $callBack Controller e função: $callBack = '{Controlller}@{function}'
     */
    public function __construct(string $method, string $path, string $callBack)
    {
        $this->setMethod($method);
        $this->setCallback($callBack);
        $this->setRoute($path);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setRoute(string $route)
    {
        $this->route = $route;
        $this->setPath($route);
    }

    /**
     * @param string $path Caminho da rota
     */
    private function setPath(string $path)
    {
        $this->parsedPath = [];
        $str_explode = explode('/', $this->fixed.$path);
        foreach ($str_explode as $key => $value) {
            if( preg_match('/{(.*?)}/', $value, $matches) ){
                $this->parsedPath[] = ['nameParam' => $matches[1], 'value' => '(param)'];
            } else {
                $this->parsedPath[] = ['nameParam' => false, 'value' => $value];
            }
        }
    }

    /**
     * @param string $callBack Controller e função: $callBack = '{Controlller}@{function}'
     */
    private function setCallback(string $callBack)
    {
        $this->callBack = AzArr::explode('@', $callBack, [ 'class', 'function' ]);
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
            if($parsed['value'] === '(param)'){
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
        $class =  env('NAMESPACE_CONTROLLERS', '\\Azuos\\Controller\\') . $this->callBack['class'];
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
        if(empty($token) || $token === 'env'){
            $this->auth['type'] = 'env';
        } else {
            $this->auth['type'] = 'token';
            $this->auth['token'] = $token;
        }
        return $this;
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