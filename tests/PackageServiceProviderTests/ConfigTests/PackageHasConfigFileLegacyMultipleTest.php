<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasConfigFileLegacyMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile(['package-tools', 'alternative-config', 'config-stub']);
    }
}

uses(PackageHasConfigFileLegacyMultipleTest::class);

it("registers multiple config files by legacy", function () {
    expect(config('package-tools.key'))->toBe('value');
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
})->group('config', 'legacy');

it("doesn't register stub config files by legacy", function () {
    expect(config('config-stub.stub_key'))->toBe(null);
})->group('config', 'legacy');

it("publishes multiple config files by legacy", function () {
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
})->group('config', 'legacy');
