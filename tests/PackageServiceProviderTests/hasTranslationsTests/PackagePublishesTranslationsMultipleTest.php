<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesTranslationsMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesTranslationsByPath()
            ->publishesTranslationsByPath('my-package', '../resources/lang_alt');
    }
}

uses(PackagePublishesTranslationsMultipleTest::class);

it("can publish both default and alternate translations", function () {
    $file1 = lang_path("vendor/package-tools/en/translations.php");
    $file2 = lang_path("vendor/my-package/es/translations.php");
    expect($file1)->not->toBeFileOrDirectory();
    expect($file2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file1)->toBeFile();
    expect($file2)->toBeFile();
})->group('translations');
