<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeCustomIfInvalidDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeCustomIf('testif', function ($expression) {
                return $expression === "hello world";
            })
            ->hasBladeCustomIf('testif', function ($expression) {
                return $expression === "hello mars";
            })
        ;
    }
}

uses(PackageBladeCustomIfInvalidDuplicateTest::class);

it("throws an exception on an attempt to define the same If directive twice")
    ->group('blade')
    ->throws(InvalidPackage::class, "hasBladeCustomIf cannot use custom If 'testif' more than once in package laravel-package-tools");
