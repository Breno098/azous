<?php

namespace Azuos\Routes;

class Route
{
    public static $routes = [];

    /**
     * @param string $route
     * @param string $controller '{Controller}@{function}'
     * 
     * @return BaseRoute
     */
    static public function get(string $route, string $controller)
    {
        return self::addRoute('get', $route, $controller);
    }

    /**
     * @param string $route
     * @param string $controller '{Controller}@{function}'
     * 
     * @return BaseRoute
     */
    static public function post(string $route, string $controller)
    {
        return self::addRoute('post', $route, $controller);
    }

    /**
     * @param string $route
     * @param string $controller '{Controller}@{function}'
     * 
     * @return BaseRoute
     */
    static public function delete(string $route, string $controller)
    {
        return self::addRoute('delete', $route, $controller);
    }

    /**
     * @param string $route
     * @param string $controller '{Controller}@{function}'
     * 
     * @return BaseRoute
     */
    static public function put(string $route, string $controller)
    {
        return self::addRoute('put', $route, $controller);
    }

    /**
     * @param string $method {get, post, puth, delete}
     * @param string $path 
     * @param string $controller 
     * 
     * @return BaseRoute
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

    /**
     * @param array $params
     * @param array $routes
    */
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

    /**
     * @param string $prefix
     * @param array $routes
     */
    static public function prefixGroup(string $prefix, array $routes = [])
    {
        foreach ($routes as $route) {
            self::prefix($prefix, $route);
        }
    }

    /**
     * @param string $sufix
     * @param array $routes
     */
    static public function sufixGroup(string $sufix, array $routes = [])
    {
        foreach ($routes as $route) {
            self::sufix($sufix, $route);
        }
    }

    /**
     * @param string $prefix
     * @param BaseRoute $route
     */
    static public function prefix(string $prefix, BaseRoute $route)
    {
        $newRoute = $prefix . $route->route;
        $route->setRoute( $newRoute );
    }

    /**
     * @param string $sufix
     * @param BaseRoute $route
     */
    static public function sufix(string $sufix, BaseRoute $route)
    {
        $newRoute = $route->route . $sufix;
        $route->setRoute( $newRoute );
    }

    /**
     * @param mixed $auth
     * @param array $routes
     */
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