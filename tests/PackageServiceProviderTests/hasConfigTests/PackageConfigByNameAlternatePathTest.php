<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageConfigByNameAlternatePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigsByName('pkg-tools', 'alternative')
            ->hasConfigsByName('stub')
            ->setConfigsByNamePath('../config_alt');
    }
}

uses(PackageConfigByNameAlternatePathTest::class);

it("registers config files by name using alternate path", function () {
    expect(config('pkg-tools.key'))->toBe('value');
    expect(config('alternative.alternative_key'))->toBe('alternative_value');
})->group('config');

it("doesn't register stub config files by name using alternate path", function () {
    expect(config('stub.stub_key'))->toBe(null);
})->group('config');

it("publishes config files by name using alternate path", function () {
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
