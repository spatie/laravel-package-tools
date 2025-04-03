<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConfigByNameTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConfigsByName('alternative-config');
    }
}

uses(PackageLoadsConfigByNameTest::class);

it("registers single config files by name", function () {
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
})->group('config');

it("doesn't publish single config files by name", function () {
    $publishedFile = config_path('alternative-config.php');
    expect($publishedFile)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFile)->not->toBeFileOrDirectory();
})->group('config');
