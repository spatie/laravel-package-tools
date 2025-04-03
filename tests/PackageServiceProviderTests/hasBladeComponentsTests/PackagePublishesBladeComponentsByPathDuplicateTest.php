<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesBladeComponentsByPathDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesBladeComponentsByPath('abc')
            ->publishesBladeComponentsByPath('abc', "Components_alt");
    }
}

uses(PackagePublishesBladeComponentsByPathDuplicateTest::class);

it("throws an exception when the Blade Components prefix is duplicated")
    ->group('blade', 'blade-components')
    ->throws(InvalidPackage::class, "publishesBladeComponentsByPath cannot use prefix 'abc' more than once in package laravel-package-tools");
