<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageAssetsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets('../invalid_path');
    }
}

uses(PackageAssetsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('assets')
        ->throws(InvalidPackage::class, "hasAssets: Directory '../invalid_path' does not exist in package laravel-package-tools");
