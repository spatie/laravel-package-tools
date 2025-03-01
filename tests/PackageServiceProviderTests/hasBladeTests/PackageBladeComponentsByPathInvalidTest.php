<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasBladeComponentsByPath('abc', "Invalid_path");
    }
}

uses(PackageBladeComponentsByPathInvalidTest::class);

it("will throw an exception when the Blade Components path is invalid")
    ->group('blade')
    ->throws(InvalidPackage::class, "hasBladeComponentsByPath: Directory 'Invalid_path' does not exist in package laravel-package-tools");
