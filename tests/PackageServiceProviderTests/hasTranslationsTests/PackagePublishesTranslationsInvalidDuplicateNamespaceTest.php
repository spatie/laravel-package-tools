<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesTranslationsInvalidDuplicateNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesTranslationsByPath()
            ->publishesTranslationsByPath(path: '../resources/dist_alt');
    }
}

uses(PackagePublishesTranslationsInvalidDuplicateNamespaceTest::class);

it("will throw an exception when the Assets namespace is duplicated")
    ->group('translations')
    ->throws(InvalidPackage::class, "publishesTranslationsByPath cannot use namespace 'package-tools' more than once in package laravel-package-tools");
