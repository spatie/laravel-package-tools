<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsTranslationsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsTranslationsByPath(path: '../invalid_path');
    }
}

uses(PackageLoadsTranslationsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('translations')
        ->throws(InvalidPackage::class, "loadsTranslationsByPath: Directory '../invalid_path' does not exist in package laravel-package-tools");
