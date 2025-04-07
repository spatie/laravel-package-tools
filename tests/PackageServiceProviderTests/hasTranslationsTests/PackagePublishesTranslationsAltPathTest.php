<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesTranslationsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesTranslationsByPath(path: '../resources/lang_alt');
    }
}

uses(PackagePublishesTranslationsAltPathTest::class);

it("can publish the alternate translations", function () {
    $file = lang_path("vendor/package-tools/es/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('translations');
