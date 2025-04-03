<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsCommandsByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsCommandsByPath('invalid_path');
    }
}

uses(PackageLoadsCommandsByPathInvalidTest::class);

it("will throw an exception when the Command loaded by path is invalid")
    ->group('commands')
    ->throws(InvalidPackage::class, "loadsCommandsByPath: Directory 'invalid_path' does not exist in package laravel-package-tools");
