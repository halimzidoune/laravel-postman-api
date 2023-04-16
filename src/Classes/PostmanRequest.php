<?php

namespace Halimzidoune\LaravelPostmanApi\Classes;

use Illuminate\Routing\Route;

class PostmanRequest
{
    protected $name;

    protected $route;

    public function __construct($name, Route $route)
    {
        $this->name = $name;
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return Illuminate\Support\Facades\Route
     */
    public function getRoute(): Route
    {
        return $this->route;
    }

    public function getMethod(){
        return $this->route->methods[0];
    }

    public function getAction(){
        $function = null;
        $controller = explode('@', $this->route->action['controller']);
        if (count($controller) == 2) {
            $controllerClass = $controller[0];
            $function = $controller[1];
        }

        return $function;
    }

    public function getController(){
        $controllerClass = null;
        $controller = explode('@', $this->route->action['controller']);
        if (count($controller) == 2) {
            $controllerClass = $controller[0];
            $function = $controller[1];
        }

        return $controllerClass;
    }
}
