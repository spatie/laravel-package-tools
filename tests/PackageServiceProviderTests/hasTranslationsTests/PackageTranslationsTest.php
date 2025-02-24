<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations();
    }
}

uses(PackageTranslationsTest::class);

it('can load the translations', function () {
    $this->assertEquals('translation', trans('package-tools::translations.translatable'));
});

it('can publish the translations', function () {
    $file = lang_path("vendor/package-tools/en/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
