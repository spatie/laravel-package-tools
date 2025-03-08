<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasTranslationsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageTranslationsAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations('my-package', '../resources/lang_alt');
    }
}

uses(PackageTranslationsAltNamespacePathTest::class);

it("can load alternate translations", function () {
    App::setLocale('es');
    $this->assertEquals('traducción', trans('my-package::translations.translatable'));
})->group('translations');

it("can publish both default and alternate translations", function () {
    $file = lang_path("vendor/my-package/es/translations.php");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('translations');
