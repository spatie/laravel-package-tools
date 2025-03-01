<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

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

it("will throw an exception when the Blade Anonymous Components path is invalid")
    ->group('blade')
    ->skip(fn () => version_compare(App::version(), '9.44.0') < 0, 'Anonymous components not available until Laravel v9.44.0')
    ->throws(InvalidPackage::class,"hasBladeAnonymousComponentsByPath: Directory 'Invalid_path' does not exist in package laravel-package-tools");
