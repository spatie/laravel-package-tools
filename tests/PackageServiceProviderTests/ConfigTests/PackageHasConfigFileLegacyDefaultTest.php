<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ConfigTests;

use Illuminate\Support\Facades\File;
use Mockery;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\TestServiceProvider;

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

it("does not resolve config file paths when configuration is cached", function () {
    $package = Mockery::mock(Package::class)->makePartial();
    $package->shouldNotReceive('basePath');
    $provider = Mockery::mock(TestServiceProvider::class, [$this->app])->makePartial();
    $provider->shouldReceive('newPackage')->once()->andReturn($package);
    config(['package-tools.key' => 'cached value']);
    $cachePath = $this->app->getCachedConfigPath();
    File::put($cachePath, '<?php return [];');
    $this->app->instance('config_loaded_from_cache', true);

    try {
        $provider->register();

        expect(config('package-tools.key'))->toBe('cached value');
    } finally {
        File::delete($cachePath);
    }
})->group('config', 'legacy');

it("still publishes config files when configuration is cached", function () {
    $provider = $this->app->getProvider(TestServiceProvider::class);
    TestServiceProvider::reset();
    $cachePath = $this->app->getCachedConfigPath();
    File::put($cachePath, '<?php return [];');
    $this->app->instance('config_loaded_from_cache', true);

    try {
        $provider->boot();
        $this->artisan('vendor:publish --tag=package-tools-config')->assertSuccessful();

        expect(config_path('package-tools.php'))->toBeFile();
    } finally {
        File::delete($cachePath);
    }
})->group('config', 'legacy');
