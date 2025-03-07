<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByNamespaceDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeComponentsByNamespace('abc', 'Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components')
            ->hasBladeComponentsByNamespace('abc', '');
    }
}

uses(PackageBladeComponentsByNamespaceDuplicateTest::class);

it("throws an exception if you use a duplicate prefix")
    ->group('blade')
    ->throws(InvalidPackage::class, "hasBladeComponentsByNamespace cannot use prefix 'abc' more than once in package laravel-package-tools");
