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
    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertExitCode(0);

    $this->assertFileExists(lang_path("vendor/package-tools/en/translations.php"));
});
