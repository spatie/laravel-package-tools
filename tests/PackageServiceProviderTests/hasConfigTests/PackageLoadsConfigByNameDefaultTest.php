<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConfigByNameDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConfigsByName();
    }
}

uses(PackageLoadsConfigByNameDefaultTest::class);

it("registers only the default config file by name", function () {
    expect(config('package-tools.key'))->toBe('value');
    expect(config('alternative-config.alternative_key'))->toBe(null);
})->group('config');

it("doesn't publish only the default config file by name", function () {
    $nonPublishedFiles = [
        config_path('package-tools.php'),
        config_path('alternative-config.php'),
        config_path('config-stub.php'),
    ];
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();
})->group('config');
