<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesViewsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesViewsByPath(path: '../invalid_path');
    }
}

uses(PackagePublishesViewsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('views')
        ->throws(InvalidPackage::class, "publishesViewsByPath: Directory '../invalid_path' does not exist in package laravel-package-tools");
