<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageInertiaInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasInertiaComponents(path: '../invalid_path');
    }
}

uses(PackageInertiaInvalidPathTest::class);

it("will throw an exception when the Inertia path doesn't exist")
        ->group('inertia')
        ->throws(InvalidPackage::class, "hasInertiaComponents: Directory '../invalid_path' does not exist in package laravel-package-tools");
