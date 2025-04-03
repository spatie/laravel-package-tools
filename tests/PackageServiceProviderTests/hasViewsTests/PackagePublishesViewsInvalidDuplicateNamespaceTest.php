<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesViewsInvalidDuplicateNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesViewsByPath()
            ->publishesViewsByPath(path: '../resources/dist_alt');
    }
}

uses(PackagePublishesViewsInvalidDuplicateNamespaceTest::class);

it("will throw an exception when the Assets namespace is duplicated")
    ->group('views')
    ->throws(InvalidPackage::class, "publishesViewsByPath cannot use namespace 'package-tools' more than once in package laravel-package-tools");
