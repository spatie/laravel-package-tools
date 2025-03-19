<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageCommandsByClassInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommandsByClass("InvalidClass");
    }
}

uses(PackageCommandsByClassInvalidTest::class);

it("will throw an exception when the Command class is invalid")
    ->group('commands')
    ->throws(InvalidPackage::class, "hasCommandsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
