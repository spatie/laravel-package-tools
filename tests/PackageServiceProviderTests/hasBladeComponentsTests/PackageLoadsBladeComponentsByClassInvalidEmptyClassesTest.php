<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByClassInvalidEmptyClassesTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsBladeComponentsByClass('abc');
    }
}

uses(PackageLoadsBladeComponentsByClassInvalidEmptyClassesTest::class);

it("will throw an exception when the Blade Component class list is empty")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "loadsBladeComponentsByClass requires parameter 'classes' to be specified in package laravel-package-tools");
