<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

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
    ->throws(InvalidPackage::class,"hasBladeComponentsByPath: Directory 'Invalid_path' does not exist in package laravel-package-tools");
