<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConsoleCommandsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageConsoleCommandsByClassInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConsoleCommandsByClass("InvalidClass");
    }
}

uses(PackageConsoleCommandsByClassInvalidTest::class);

it("will throw an exception when the Console Command class loaded by name is invalid")
    ->group('commands')
    ->throws(InvalidPackage::class, "hasConsoleCommandsByClass: Class 'InvalidClass' does not exist in package laravel-package-tools");
