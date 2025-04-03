<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByClassInvalidClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsBladeComponentsByClass('abc', "InvalidClass");
    }
}

uses(PackageLoadsBladeComponentsByClassInvalidClassTest::class);

it("will throw an exception when the Blade Component class is invalid")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "loadsBladeComponentsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
