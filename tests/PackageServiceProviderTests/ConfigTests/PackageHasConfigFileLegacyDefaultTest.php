<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasConfigFileLegacyDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile();
    }
}

uses(PackageHasConfigFileLegacyDefaultTest::class);

it("registers only the default config file by legacy", function () {
    expect(config('package-tools.key'))->toBe('value');
})->group('config', 'legacy');

it("publishes only the default config file by legacy", function () {
    $publishedFiles = [
        config_path('package-tools.php'),
    ];
    $nonPublishedFiles = [
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
})->group('config', 'legacy');
