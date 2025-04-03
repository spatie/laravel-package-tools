<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesAssetsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesAssetsByPath(path: '../invalid_path');
    }
}

uses(PackagePublishesAssetsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('assets')
        ->throws(InvalidPackage::class, "publishesAssetsByPath: Directory '../invalid_path' does not exist in package laravel-package-tools");
