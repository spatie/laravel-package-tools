<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesTranslationsAltNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesTranslationsByPath('my-package');
    }
}

uses(PackagePublishesTranslationsAltNamespaceTest::class);

it("can publish the translations", function () {
    $file = lang_path("vendor/my-package/en/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('translations');
