<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesConfigByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesConfigsByPath("InvalidPath");
    }
}

uses(PackagePublishesConfigByPathInvalidTest::class);

it("will throw an exception when the Config path is invalid")
    ->group('config')
    ->throws(InvalidPackage::class, "publishesConfigsByPath: Directory 'InvalidPath' does not exist in package laravel-package-tools");
