<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageConfigByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigsByPath();
    }
}

uses(PackageConfigByPathDefaultTest::class);

it("registers config files by path", function () {
    expect(config('package-tools.key'))->toBe('value');
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
    expect(config('unpublished-config.unpublished_key'))->toBe('unpublished_value');
})->group('config');

it("doesn't register stub config files by path", function () {
    expect(config('config-stub.stub_key'))->toBe(null);
    expect(config('unpublished-stub.unpublished_stub_key'))->toBe(null);
})->group('config');

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
