<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageViewsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews(path: '../invalid_path');
    }
}

uses(PackageViewsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('views')
        ->throws(InvalidPackage::class, "hasViews: Directory '../invalid_path' does not exist in package laravel-package-tools");
