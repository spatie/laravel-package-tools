<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByClassInvalidEmptyClassesTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasBladeComponentsByClass('abc');
    }
}

uses(PackageBladeComponentsByClassInvalidEmptyClassesTest::class);

it("will throw an exception when the Blade Component class list is empty")
    ->group('blade')
    ->throws(InvalidPackage::class, "hasBladeComponentsByClass requires parameter 'classes' to be specified in package laravel-package-tools");
