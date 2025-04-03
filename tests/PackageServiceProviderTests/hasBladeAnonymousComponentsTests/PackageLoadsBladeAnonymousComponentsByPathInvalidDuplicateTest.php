<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeAnonymousComponentsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeAnonymousComponentsByPathInvalidDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
                ->loadsViewsByPath()
                ->loadsBladeAnonymousComponentsByPath('abc')
                ->loadsBladeAnonymousComponentsByPath('abc', "../resources/views_alt/components");
    }
}

uses(PackageLoadsBladeAnonymousComponentsByPathInvalidDuplicateTest::class);

it("will throw an exception with loadsBladeAnonymousComponentsByPath when the Laravel version is before 9.44.0")
    ->group('blade', 'blade-anonymous')
    ->skip(fn () => ! is_before_laravel_version(App::version(), '9.44.0'), "loadsBladeAnonymousComponentsByPath only throws InvalidPackage on Laravel < 9.44.0")
    ->throws(InvalidPackage::class, "loadsBladeAnonymousComponentsByPath requires functionality first implemented in Laravel v9.44.0 in package laravel-package-tools");

it("will throw an exception when the loadsBladeAnonymousComponentsByPath prefix is duplicated")
    ->group('blade', 'blade-anonymous')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '9.44.0'),
        message_before_laravel_version('9.44.0', 'loadsBladeAnonymousComponentsByPath')
    )
    ->throws(InvalidPackage::class, "loadsBladeAnonymousComponentsByPath cannot use prefix 'abc' more than once in package laravel-package-tools");
