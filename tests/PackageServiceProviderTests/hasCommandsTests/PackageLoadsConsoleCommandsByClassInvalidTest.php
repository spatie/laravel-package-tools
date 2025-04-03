<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConsoleCommandsByClassInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConsoleCommandsByClass("InvalidClass");
    }
}

uses(PackageLoadsConsoleCommandsByClassInvalidTest::class);

it("will throw an exception when the Console Command class loaded by name is invalid")
    ->group('commands')
    ->throws(InvalidPackage::class, "loadsConsoleCommandsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
