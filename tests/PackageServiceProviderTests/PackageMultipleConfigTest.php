<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageMultipleConfigTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile(['package-tools', 'alternative-config']);
    }

    /** @test */
    public function it_can_register_multiple_config_files()
    {
        $this->assertEquals('value', config('package-tools.key'));

        $this->assertEquals('alternative_value', config('alternative-config.alternative_key'));

    }
}
