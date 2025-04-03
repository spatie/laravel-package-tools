<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesTranslationsInvalidPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesTranslationsByPath(path: '../invalid_path');
    }
}

uses(PackagePublishesTranslationsInvalidPathTest::class);

it("will throw an exception when the Assets path doesn't exist")
        ->group('translations')
        ->throws(InvalidPackage::class, "publishesTranslationsByPath: Directory '../invalid_path' does not exist in package laravel-package-tools");
