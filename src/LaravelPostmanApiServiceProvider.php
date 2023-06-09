<?php

namespace Halimzidoune\LaravelPostmanApi;

use Halimzidoune\LaravelPostmanApi\Commands\LaravelPostmanApiCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelPostmanApiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-postman-api')
            ->hasConfigFile()
            ->hasViews()
            ->hasCommand(LaravelPostmanApiCommand::class);
    }
}
