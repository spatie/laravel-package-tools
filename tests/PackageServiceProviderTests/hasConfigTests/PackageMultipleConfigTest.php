<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasConfigTests;

use Spatie\LaravelPackageTools\Package;

trait PackageMultipleConfigTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile(['package-tools', 'alternative-config']);
    }
}

uses(PackageMultipleConfigTest::class);

it('can register multiple config files', function () {
    expect(config('package-tools.key'))->toBe('value');
    expect(config('alternative-config.alternative_key'))->toBe('alternative_value');
});

it('can publish multiple config files', function () {
    $file = config_path('alternative-config.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
