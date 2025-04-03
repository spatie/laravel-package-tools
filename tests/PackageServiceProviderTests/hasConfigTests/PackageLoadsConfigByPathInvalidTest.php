<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConfigByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConfigsByPath("InvalidPath");
    }
}

uses(PackageLoadsConfigByPathInvalidTest::class);

it("will throw an exception when the Config path is invalid")
    ->group('config')
    ->throws(InvalidPackage::class, "loadsConfigsByPath: Directory 'InvalidPath' does not exist in package laravel-package-tools");
