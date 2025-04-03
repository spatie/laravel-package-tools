<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesConfigByNameMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesConfigsByName('package-tools', 'alternative-config')
            ->publishesConfigsByName('config-stub');
    }
}

uses(PackagePublishesConfigByNameMultipleTest::class);

it("publishes multiple config files by name", function () {
    $publishedFiles = [
        config_path('package-tools.php'),
        config_path('alternative-config.php'),
        config_path('config-stub.php'),
    ];
    $nonPublishedFiles = [
        config_path('unpublished-config.php'),
        config_path('unpublished-stub.php'),
    ];
    expect($publishedFiles)->each->not->toBeFileOrDirectory();
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFiles)->each->toBeFile();
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();
})->group('config');
