<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeCustomDirectiveInvalidDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeCustomDirective('testdirective', function ($expression) {
                return '<div><?php echo $expression; ?></div>';
            })
            ->hasBladeCustomDirective('testdirective', function ($expression) {
                return '<div><?php echo "duplicate"; ?></div>';
            })
        ;
    }
}

uses(PackageBladeCustomDirectiveInvalidDuplicateTest::class);

it("throws an exception on an attempt to define the same Blade directive twice")
    ->group('blade')
    ->throws(InvalidPackage::class, "hasBladeCustomDirective cannot use custom directive 'testdirective' more than once in package laravel-package-tools");
