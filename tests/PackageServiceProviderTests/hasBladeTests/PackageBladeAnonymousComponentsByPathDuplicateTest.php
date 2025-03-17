<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeAnonymousComponentsByPathDuplicateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
                ->hasViews()
                ->hasBladeAnonymousComponentsByPath('abc')
                ->hasBladeAnonymousComponentsByPath('abc', "../resources/views_alt/components");
    }
}

uses(PackageBladeAnonymousComponentsByPathDuplicateTest::class);

it("will throw an exception with hasBladeAnonymousComponentsByPath when the Laravel version is before 9.44.0")
    ->group('blade')
    ->skip(fn () => ! is_before_laravel_version(App::version(), '9.44.0'), "hasBladeAnonymousComponentsByPath will only throw an InvalidPackage exception on Laravel < 9.44.0")
    ->throws(InvalidPackage::class, "hasBladeAnonymousComponentsByPath requires functionality first implemented in Laravel v9.44.0 in package laravel-package-tools");

it("will throw an exception when the hasBladeAnonymousComponents prefix is duplicated")
    ->group('blade')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '9.44.0'),
        message_before_laravel_version('9.44.0', 'hasAnonymousComponentsByPath')
    )
    ->throws(InvalidPackage::class, "hasBladeAnonymousComponentsByPath cannot use prefix 'abc' more than once in package laravel-package-tools");
