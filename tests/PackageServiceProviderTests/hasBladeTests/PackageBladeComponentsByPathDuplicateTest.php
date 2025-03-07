<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByPathDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasBladeComponentsByPath('abc')
            ->hasBladeComponentsByPath('abc', "Components_alt");
    }
}

uses(PackageBladeComponentsByPathDuplicateTest::class);

it("throws an exception when the Blade Components prefix is duplicated")
    ->group('blade')
    ->throws(InvalidPackage::class, "hasBladeComponentsByPath cannot use prefix 'abc' more than once in package laravel-package-tools");
