<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsAltNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations('my-package');
    }
}

uses(PackageTranslationsAltNamespaceTest::class);

it("can load the translations", function () {
    $this->assertEquals('translation', trans('my-package::translations.translatable'));
})->group('translations');

it("can publish the translations", function () {
    $file = lang_path("vendor/my-package/en/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('translations');
