<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath(path: '../invalid_path');
    }
}

uses(PackagePublishesInertiaInvalidPathTest::class);

it("will throw an exception when the Inertia path doesn't exist")
        ->group('inertia')
        ->throws(InvalidPackage::class, "publishesInertiaComponentsByPath: Directory '../invalid_path' does not exist in package laravel-package-tools");
