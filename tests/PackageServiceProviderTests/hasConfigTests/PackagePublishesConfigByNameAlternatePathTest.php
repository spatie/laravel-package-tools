<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesConfigByNameAlternatePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesConfigsByName('pkg-tools', 'alternative')
            ->publishesConfigsByName('stub')
            ->setConfigsByNamePath('../config_alt');
    }
}

uses(PackagePublishesConfigByNameAlternatePathTest::class);

it("publishes config files by name using alternate path and can access values", function () {
    $publishedFiles = [
        config_path('pkg-tools.php'),
        config_path('alternative.php'),
        config_path('stub.php'),
    ];
    $nonPublishedFiles = [
        config_path('package-tools.php'),
        config_path('alternative-config.php'),
        config_path('config-stub.php'),
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
