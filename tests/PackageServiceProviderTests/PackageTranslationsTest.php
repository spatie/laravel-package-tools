<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasTranslations();

    PackageServiceProviderConcreteTestCase::package($package);
});


it('can_load_the_translations', function () {

    $this->assertEquals('translation', trans('package-tools::translations.translatable'));
});

it('can_publish_the_translations', function () {

    $this
        ->artisan('vendor:publish --tag=package-tools-translations')
        ->assertExitCode(0);

    $path = (function_exists('lang_path'))
        ? lang_path("vendor/package-tools/en/translations.php")
        : resource_path("lang/vendor/package-tools/en/translations.php");

    $this->assertFileExists($path);
});
