<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesConfigByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesConfigsByPath();
    }
}

uses(PackagePublishesConfigByPathDefaultTest::class);

it("publishes config files by path", function () {
    $publishedFiles = [
        config_path('package-tools.php'),
        config_path('alternative-config.php'),
        config_path('config-stub.php'),
        config_path('unpublished-config.php'),
        config_path('unpublished-stub.php'),
    ];
    expect($publishedFiles)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFiles)->each->toBeFile();
})->group('config');
