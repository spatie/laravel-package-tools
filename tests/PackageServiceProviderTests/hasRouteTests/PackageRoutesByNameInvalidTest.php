<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageRoutesByNameInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutesByName("InvalidFile");
    }
}

uses(PackageRoutesByNameInvalidTest::class);

it("will throw an exception when the Config filename is invalid")
    ->group('routes')
    ->throws(InvalidPackage::class, "hasRoutesByName: Routes filename 'InvalidFile' is neither .php or .php.stub in package laravel-package-tools");
