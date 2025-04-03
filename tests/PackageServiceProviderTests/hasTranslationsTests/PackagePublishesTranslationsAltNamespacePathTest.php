<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesTranslationsAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesTranslationsByPath('my-package', '../resources/lang_alt');
    }
}

uses(PackagePublishesTranslationsAltNamespacePathTest::class);

it("can publish both default and alternate translations", function () {
    $file = lang_path("vendor/my-package/es/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('translations');
