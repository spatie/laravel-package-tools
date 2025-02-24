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
    $this->assertEquals('value', config('package-tools.key'));

    $this->assertEquals('alternative_value', config('alternative-config.alternative_key'));
});

it('can publish multiple config files', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertExitCode(0);

    $this->assertFileExists(config_path('alternative-config.php'));
});
