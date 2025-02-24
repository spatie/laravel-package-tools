<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageConfigTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile();
    }
}

uses(PackageConfigTest::class);

it('can register the config file', function () {
    expect(config('package-tools.key'))->toBe('value');
});

it('can publish the config file', function () {
    $file = config_path('package-tools.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
