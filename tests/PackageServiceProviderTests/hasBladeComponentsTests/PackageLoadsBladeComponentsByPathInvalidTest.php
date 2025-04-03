<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsBladeComponentsByPath('abc', "Invalid_path");
    }
}

uses(PackageLoadsBladeComponentsByPathInvalidTest::class);

it("will throw an exception when the Blade Components path is invalid")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "loadsBladeComponentsByPath: Directory 'Invalid_path' does not exist in package laravel-package-tools");
