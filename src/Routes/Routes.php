<?php

namespace Azous\Routes;

class Routes
{
    private static $routes = [];
    private static $archivePth = '/index.php';

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
        $route = new Route($method, self::$archivePth . $path, $controller);
        self::$routes[] = $route;
        return $route;
    }

    static public function run()
    {
        foreach (self::$routes as $route){
            $route->verify() ? $route->run() : null;
        }
    }

}