<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByPathDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsBladeComponentsByPath('abc')
            ->loadsBladeComponentsByPath('abc', "Components_alt");
    }
}

uses(PackageLoadsBladeComponentsByPathDuplicateTest::class);

it("throws an exception when the Blade Components prefix is duplicated")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "loadsBladeComponentsByPath cannot use prefix 'abc' more than once in package laravel-package-tools");
