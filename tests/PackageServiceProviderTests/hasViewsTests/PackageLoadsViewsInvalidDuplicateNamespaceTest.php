<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsViewsInvalidDuplicateNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsViewsByPath(path: '../resources/dist_alt');
    }
}

uses(PackageLoadsViewsInvalidDuplicateNamespaceTest::class);

it("will throw an exception when the Assets namespace is duplicated")
    ->group('views')
    ->throws(InvalidPackage::class, "loadsViewsByPath cannot use namespace 'package-tools' more than once in package laravel-package-tools");
