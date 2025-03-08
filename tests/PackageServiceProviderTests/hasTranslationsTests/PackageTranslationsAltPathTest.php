<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations(path: '../resources/lang_alt');
    }
}

uses(PackageTranslationsAltPathTest::class);

it("can load the alternate translations", function () {
    App::setLocale('es');
    $this->assertEquals('traducción', trans('package-tools::translations.translatable'));
})->group('translations');

it("can publish the alternate translations", function () {
    $file = lang_path("vendor/package-tools/es/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('translations');
