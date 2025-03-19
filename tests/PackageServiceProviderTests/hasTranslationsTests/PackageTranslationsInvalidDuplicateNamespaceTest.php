<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsInvalidDuplicateNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations()
            ->hasTranslations(path: '../resources/dist_alt');
    }
}

uses(PackageTranslationsInvalidDuplicateNamespaceTest::class);

it("will throw an exception when the Assets namespace is duplicated")
    ->group('translations')
    ->throws(InvalidPackage::class, "hasTranslations cannot use namespace 'package-tools' more than once in package laravel-package-tools");
