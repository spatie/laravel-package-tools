<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsTranslationsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsTranslationsByPath(path: '../resources/lang_alt');
    }
}

uses(PackageLoadsTranslationsAltPathTest::class);

it("can load the alternate translations", function () {
    App::setLocale('es');
    $this->assertEquals('traducción', trans('package-tools::translations.translatable'));
})->group('translations');
