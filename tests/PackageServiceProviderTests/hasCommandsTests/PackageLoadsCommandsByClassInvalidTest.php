<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsCommandsByClassInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsCommandsByClass("InvalidClass");
    }
}

uses(PackageLoadsCommandsByClassInvalidTest::class);

it("will throw an exception when the Command class is invalid")
    ->group('commands')
    ->throws(InvalidPackage::class, "loadsCommandsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
