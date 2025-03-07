<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageAssetsInvalidDuplicateNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets()
            ->hasAssets(path: '../resources/dist_alt');
    }
}

uses(PackageAssetsInvalidDuplicateNamespaceTest::class);

it("will throw an exception when the Assets namespace is duplicated")
    ->group('assets')
    ->throws(InvalidPackage::class, "hasAssets cannot use namespace 'package-tools' more than once in package laravel-package-tools");
