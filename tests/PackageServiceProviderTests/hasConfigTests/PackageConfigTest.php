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
    $this->assertEquals('value', config('package-tools.key'));
});

it('can publish the config file', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertExitCode(0);

    $this->assertFileExists(config_path('package-tools.php'));
});
