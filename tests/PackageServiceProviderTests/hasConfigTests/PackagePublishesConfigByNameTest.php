<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesConfigByNameTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesConfigsByName('alternative-config');
    }
}

uses(PackagePublishesConfigByNameTest::class);

it("publishes single config files by name", function () {
    $publishedFile = config_path('alternative-config.php');
    expect($publishedFile)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFile)->toBeFile();
})->group('config');
