<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageConfigByNameTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigByName('alternative-config');
    }
}

uses(PackageConfigByNameTest::class);

it("registers single config files by name", function () {
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
})->group('config');

it("publishes single config files by name", function () {
    $publishedFile = config_path('alternative-config.php');
    expect($publishedFile)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFile)->toBeFile();
})->group('config');
