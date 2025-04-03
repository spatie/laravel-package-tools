<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConfigByNameMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConfigsByName('package-tools', 'alternative-config')
            ->loadsConfigsByName('config-stub');
    }
}

uses(PackageLoadsConfigByNameMultipleTest::class);

it("registers multiple config files by name", function () {
    expect(config('package-tools.key'))->toBe('value');
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
})->group('config');

it("doesn't register stub config files by name", function () {
    expect(config('config-stub.stub_key'))->toBe(null);
})->group('config');

it("doesn't publish multiple config files by name", function () {
    $nonPublishedFiles = [
        config_path('package-tools.php'),
        config_path('alternative-config.php'),
        config_path('config-stub.php'),
        config_path('unpublished-config.php'),
        config_path('unpublished-stub.php'),
    ];
    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($nonPublishedFiles)->each->not->toBeFileOrDirectory();
})->group('config');
