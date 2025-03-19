<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageConsoleCommandsByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConsoleCommandsByPath('invalid_path');
    }
}

uses(PackageConsoleCommandsByPathInvalidTest::class);

it("will throw an exception when the Command loaded by path is invalid")
    ->group('commands')
    ->throws(InvalidPackage::class, "hasConsoleCommandsByPath: Directory 'invalid_path' does not exist in package laravel-package-tools");
