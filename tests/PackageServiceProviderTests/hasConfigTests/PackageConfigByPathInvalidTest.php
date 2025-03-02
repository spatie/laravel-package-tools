<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageConfigByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigByPath("InvalidPath");
    }
}

uses(PackageConfigByPathInvalidTest::class);

it("will throw an exception when the Config path is invalid")
    ->group('config')
    ->throws(InvalidPackage::class, "hasConfigByPath: Directory 'InvalidPath' does not exist in package laravel-package-tools");
