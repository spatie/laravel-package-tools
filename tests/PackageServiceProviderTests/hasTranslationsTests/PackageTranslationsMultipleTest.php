<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations()
            ->hasTranslations('my-package', '../resources/lang_alt');
    }
}

uses(PackageTranslationsMultipleTest::class);

it("can load both default and alternate translations", function () {
    $this->assertEquals('translation', trans('package-tools::translations.translatable'));
    App::setLocale('es');
    $this->assertEquals('traducción', trans('my-package::translations.translatable'));
})->group('translations');

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
