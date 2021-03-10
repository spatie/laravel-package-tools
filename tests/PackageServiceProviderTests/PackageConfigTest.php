<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageConfigTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile();
    }

    /** @test */
    public function it_can_register_the_config_file()
    {
        $this->assertEquals('value', config('package-tools.key'));
    }

    /** @test */
    public function it_can_publish_the_config_file()
    {
        $this
            ->artisan('vendor:publish --tag=package-tools-config')
            ->assertExitCode(0);

        $this->assertFileExists(config_path('package-tools.php'));
    }
}
