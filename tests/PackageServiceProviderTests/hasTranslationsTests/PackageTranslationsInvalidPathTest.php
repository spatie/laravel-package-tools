<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations(path: '../invalid_path');
    }
}

uses(PackageTranslationsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('translations')
        ->throws(InvalidPackage::class, "hasTranslations: Directory '../invalid_path' does not exist in package laravel-package-tools");
