<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConfigByNameInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConfigsByName("InvalidFile");
    }
}

uses(PackageLoadsConfigByNameInvalidTest::class);

it("will throw an exception when the Config filename is invalid")
    ->group('config')
    ->throws(InvalidPackage::class, "loadsConfigsByName: Config filename 'InvalidFile' is neither .php or .php.stub in package laravel-package-tools");
