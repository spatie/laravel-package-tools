<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByClassInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasBladeComponentsByClass('abc', "InvalidClass");
    }
}

uses(PackageBladeComponentsByClassInvalidTest::class);

it("will throw an exception when the Blade Component class is invalid")
    ->throws(InvalidPackage::class, "hasBladeComponentsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
