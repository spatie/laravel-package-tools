<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageConfigByNameInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigsByName("InvalidFile");
    }
}

uses(PackageConfigByNameInvalidTest::class);

it("will throw an exception when the Config filename is invalid")
    ->group('config')
    ->throws(InvalidPackage::class, "hasConfigsByName: Config filename 'InvalidFile' is neither .php or .php.stub in package laravel-package-tools");
