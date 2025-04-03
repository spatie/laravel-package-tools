<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsConfigByPathAlternateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsConfigsByPath('../config_alt');
    }
}

uses(PackageLoadsConfigByPathAlternateTest::class);

it("registers config files by alternate path", function () {
    expect(config('pkg-tools.key'))->toBe('value');
    expect(config('alternative.alternative_key'))->toBe('alternative_value');
})->group('config');

it("doesn't register stub config files by alternate path", function () {
    expect(config('stub.stub_key'))->toBe(null);
})->group('config');

it("doesn't publish config files by alternate path", function () {
    $nonPublishedFiles = [
        config_path('pkg-tools.php'),
        config_path('alternative.php'),
        config_path('stub.php'),
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
