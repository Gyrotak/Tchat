<?php

namespace App\Service\Router;

use App\Service\Router\Route;

class Router {

    private $url;
    private $routes = [];
    private $namedRoutes = [];

    public function __construct($url){
        $this->url = $url;
    }

    /*
     * Add URL with Method GET
     * 
     * @param $path string
     * @param $callable string
     * @param $name string
     *
     * @return \Route
     */
    public function get($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'GET');
    }

    /*
     * Add URL with Method POST
     *
     * @param $path string
     * @param $callable string
     * @param $name string
     *
     * @return \Route
     */
    public function post($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }

    /*
     * Add URL to array routes with method
     *
     * @param $path string
     * @param $callable string
     * @param $name string
     * @param $method string
     *
     * @return \Route
     */
    private function add($path, $callable, $name, $method){
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if(is_string($callable) && $name === null){
            $name = $callable;
        }
        if($name){
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }


    /*
     * Call specific routes on array, depend of URL
     *
     * @return \Route->call (Call function link with this URL)
     */
    public function run(){
        if(!isset($this->routes[$_SERVER['REQUEST_METHOD']])){
            throw new Exception('REQUEST_METHOD does not exist');
        }
        foreach($this->routes[$_SERVER['REQUEST_METHOD']] as $route){
            if($route->match($this->url)){
                return $route->call();
            }
        }
        throw new Exception('No matching routes');
    }

    /*
     * @param $name string
     * @param $params array
     *
     * @return array 
     */
    public function url($name, $params = []){
        if(!isset($this->namedRoutes[$name])){
            throw new Exception('No route matches this name');
        }
        return $this->namedRoutes[$name]->getUrl($params);
    }

}

?>