<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\TranslationsTests;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Package;

trait PackageHasTranslationsLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasTranslations();
    }
}

uses(PackageHasTranslationsLegacyTest::class);

it('can load the translations', function () {
    assertEquals('translation', trans('package-tools::translations.translatable'));
});

it('can publish the translations', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertExitCode(0);

    $path = (function_exists('lang_path'))
        ? lang_path("vendor/package-tools/en/translations.php")
        : resource_path("lang/vendor/package-tools/en/translations.php");

    assertFileExists($path);
});
