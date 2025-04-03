<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsTranslationsMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsTranslationsByPath()
            ->loadsTranslationsByPath('my-package', '../resources/lang_alt');
    }
}

uses(PackageLoadsTranslationsMultipleTest::class);

it("can load both default and alternate translations", function () {
    $this->assertEquals('translation', trans('package-tools::translations.translatable'));
    App::setLocale('es');
    $this->assertEquals('traducción', trans('my-package::translations.translatable'));
})->group('translations');
