<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsTranslationsAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsTranslationsByPath('my-package', '../resources/lang_alt');
    }
}

uses(PackageLoadsTranslationsAltNamespacePathTest::class);

it("can load alternate translations", function () {
    App::setLocale('es');
    $this->assertEquals('traducción', trans('my-package::translations.translatable'));
})->group('translations');
