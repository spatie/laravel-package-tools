<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeCustomDirectivesTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeCustomDirectiveInvalidDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeCustomDirective('testdirective', function ($expression) {
                return '<div><?php echo $expression; ?></div>';
            })
            ->loadsBladeCustomDirective('testdirective', function ($expression) {
                return '<div><?php echo "duplicate"; ?></div>';
            })
        ;
    }
}

uses(PackageLoadsBladeCustomDirectiveInvalidDuplicateTest::class);

it("throws an exception on an attempt to define the same Blade directive twice")
    ->group('blade', 'blade-directives')
    ->throws(InvalidPackage::class, "loadsBladeCustomDirective cannot use custom directive 'testdirective' more than once in package laravel-package-tools");
