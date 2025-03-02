<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeAnonymousComponentsByPathInvalidTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasBladeAnonymousComponentsByPath('abc', "Invalid_path");
    }
}

uses(PackageBladeAnonymousComponentsByPathInvalidTest::class);

it("will throw an exception when the Laravel version is before 9.44.0")
    ->group('blade')
    ->skip(fn () => ! is_before_laravel_9_44_0(App::version()), "This function can only be tested on Laravel < 9.44.0")
    ->throws(InvalidPackage::class, "hasBladeAnonymousComponentsByPath is not supported in this version of Laravel (< 9.44.0) in package laravel-package-tools");

it("will throw an exception when the Blade Anonymous Components path is invalid")
    ->group('blade')
    ->skip(fn () => is_before_laravel_9_44_0(App::version()), message_before_laravel_9_44_0())
    ->throws(InvalidPackage::class, "hasBladeAnonymousComponentsByPath: Directory 'Invalid_path' does not exist in package laravel-package-tools");
