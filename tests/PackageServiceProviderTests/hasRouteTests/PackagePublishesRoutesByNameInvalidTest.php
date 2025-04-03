<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesRoutesByNameInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesRoutesByName("InvalidFile");
    }
}

uses(PackagePublishesRoutesByNameInvalidTest::class);

it("will throw an exception when the Config filename is invalid")
    ->group('routes')
    ->throws(InvalidPackage::class, "publishesRoutesByName: Routes filename 'InvalidFile' is neither .php or .php.stub in package laravel-package-tools");
