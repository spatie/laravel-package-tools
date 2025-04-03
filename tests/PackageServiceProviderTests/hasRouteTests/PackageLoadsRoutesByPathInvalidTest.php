<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsRoutesByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsRoutesByPath("InvalidPath");
    }
}

uses(PackageLoadsRoutesByPathInvalidTest::class);

it("will throw an exception when the Config path is invalid")
    ->group('routes')
    ->throws(InvalidPackage::class, "loadsRoutesByPath: Directory 'InvalidPath' does not exist in package laravel-package-tools");
