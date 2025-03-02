<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageConfigByNameMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigByName('package-tools', 'alternative-config')
            ->hasConfigByName('config-stub');
    }
}

uses(PackageConfigByNameMultipleTest::class);

it("registers multiple config files by name", function () {
    expect(config('package-tools.key'))->toBe('value');
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
})->group('config');

it("doesn't register stub config files by name", function () {
    expect(config('config-stub.stub_key'))->toBe(null);
})->group('config');

it("publishes multiple config files by name", function () {
    $publishedFiles = [
        config_path('package-tools.php'),
        config_path('alternative-config.php'),
        config_path('config-stub.php')
    ];
    $nonPublishedFiles = [
        config_path('unpublished-config.php'),
        config_path('unpublished-stub.php')
    ];
    expect($publishedFiles)->each->not->toBeFileOrDirectory();
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($publishedFiles)->each->toBeFile();
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();
})->group('config');
