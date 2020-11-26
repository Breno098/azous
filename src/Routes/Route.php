<?php

namespace Azuos\Routes;

class Route
{
    public static $routes = [];

    /**
     * @param string $route Rota de acesso
     * @param string $controller Controller e função: $controller = '{Controller}@{function}'
     */
    static public function get(string $route, string $controller)
    {
        return self::addRoute('get', $route, $controller);
    }

    /**
     * @param string $route Rota de acesso
     * @param string $controller Controller e função: $controller = '{Controller}@{function}'
     */
    static public function post(string $route, string $controller)
    {
        return self::addRoute('post', $route, $controller);
    }

    /**
     * @param string $route Rota de acesso
     * @param string $controller Controller e função: $controller = '{Controller}@{function}'
     */
    static public function delete(string $route, string $controller)
    {
        return self::addRoute('delete', $route, $controller);
    }

    /**
     * @param string $route Rota de acesso
     * @param string $controller Controller e função: $controller = '{Controller}@{function}'
     */
    static public function put(string $route, string $controller)
    {
        return self::addRoute('put', $route, $controller);
    }

    /**
     * @param string $method 
     * @param string $path 
     * @param string $controller 
     */
    static private function addRoute(string $method, string $path, string $controller)
    {
        $route = new BaseRoute($method, $path, $controller);
        self::$routes[] = $route;
        return $route;
    }

    static public function run()
    {
        foreach (self::$routes as $route){
            $route->verify() ? $route->run() : null;
        }
    }

    static public function group(array $params, array $routes = [])
    {
        if( isset($params['auth']) ){
            self::authGroup( $params['auth'], $routes);
        }

        if( isset($params['prefix']) ){
           self::prefixGroup( $params['prefix'], $routes);
        }

        if( isset($params['sufix']) ){
            self::sufixGroup( $params['sufix'], $routes);
        }
    }

    static public function prefixGroup(string $prefix, array $routes = [])
    {
        foreach ($routes as $route) {
            self::prefix($prefix, $route);
        }
    }

    static public function sufixGroup(string $sufix, array $routes = [])
    {
        foreach ($routes as $route) {
            self::sufix($sufix, $route);
        }
    }

    static public function prefix(string $prefix, BaseRoute $route)
    {
        $newRoute = $prefix . $route->route;
        $route->setRoute( $newRoute );
    }

    static public function sufix(string $sufix, BaseRoute $route)
    {
        $newRoute = $route->route . $sufix;
        $route->setRoute( $newRoute );
    }

    static public function authGroup($auth = null, array $routes = [])
    {
        foreach ($routes as $route) {
            if($route->getMethod() === 'GET'){
                self::sufix('/{auth}', $route);
            }
            $route->auth($auth);
        }
    }
}