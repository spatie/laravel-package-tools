<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByNamespaceDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeComponentsByNamespace('abc', 'Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components')
            ->loadsBladeComponentsByNamespace('abc', '');
    }
}

uses(PackageLoadsBladeComponentsByNamespaceDuplicateTest::class);

it("throws an exception if you use a duplicate prefix")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "loadsBladeComponentsByNamespace cannot use prefix 'abc' more than once in package laravel-package-tools");
