<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesConfigByPathAlternateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesConfigsByPath('../config_alt');
    }
}

uses(PackagePublishesConfigByPathAlternateTest::class);

it("publishes config files by alternate path", function () {
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
