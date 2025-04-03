<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeCustomDirectivesTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeCustomIfInvalidDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeCustomIf('testif', function ($expression) {
                return $expression === "hello world";
            })
            ->loadsBladeCustomIf('testif', function ($expression) {
                return $expression === "hello mars";
            })
        ;
    }
}

uses(PackageLoadsBladeCustomIfInvalidDuplicateTest::class);

it("throws an exception on an attempt to define the same If directive twice")
    ->group('blade', 'blade-directives')
    ->throws(InvalidPackage::class, "loadsBladeCustomIf cannot use custom If 'testif' more than once in package laravel-package-tools");
