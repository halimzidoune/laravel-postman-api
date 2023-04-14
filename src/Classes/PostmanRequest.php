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
}
