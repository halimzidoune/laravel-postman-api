<?php

namespace Halimzidoune\LaravelPostmanApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Halimzidoune\LaravelPostmanApi\LaravelPostmanApi
 */
class LaravelPostmanApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Halimzidoune\LaravelPostmanApi\LaravelPostmanApi::class;
    }
}
