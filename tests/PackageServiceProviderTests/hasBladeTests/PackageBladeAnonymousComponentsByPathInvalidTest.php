<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeAnonymousComponentsByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasBladeAnonymousComponentsByPath('abc', "Invalid_path");
    }
}

uses(PackageBladeAnonymousComponentsByPathInvalidTest::class);

it("will throw an exception when the Blade Anonymous Components path is invalid")
    ->throws(InvalidPackage::class, "hasBladeAnonymousComponentsByPath: Directory 'Invalid_path' does not exist in package laravel-package-tools");
