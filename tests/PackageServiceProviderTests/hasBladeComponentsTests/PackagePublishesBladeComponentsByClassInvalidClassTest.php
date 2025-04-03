<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesBladeComponentsByClassInvalidClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesBladeComponentsByClass('abc', "InvalidClass");
    }
}

uses(PackagePublishesBladeComponentsByClassInvalidClassTest::class);

it("will throw an exception when the Blade Component class is invalid")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "publishesBladeComponentsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
