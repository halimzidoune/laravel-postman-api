<?php

namespace Halimzidoune\LaravelPostmanApi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Halimzidoune\LaravelPostmanApi\Commands\LaravelPostmanApiCommand;

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
            ->hasMigration('create_laravel-postman-api_table')
            ->hasCommand(LaravelPostmanApiCommand::class);
    }
}
