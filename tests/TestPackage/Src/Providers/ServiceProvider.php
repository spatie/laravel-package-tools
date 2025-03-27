<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Providers;

use Closure;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ServiceProvider extends PackageServiceProvider
{
    public function getPackageBaseDir():string
    {
        return parent::getPackageBaseDir();
    }

    public function configurePackage(Package $package): void
    {
        $package->name('laravel-package-tools');
    }
}
