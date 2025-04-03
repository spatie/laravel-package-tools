<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsTranslationsAltNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsTranslationsByPath('my-package');
    }
}

uses(PackageLoadsTranslationsAltNamespaceTest::class);

it("can load the translations", function () {
    $this->assertEquals('translation', trans('my-package::translations.translatable'));
})->group('translations');
