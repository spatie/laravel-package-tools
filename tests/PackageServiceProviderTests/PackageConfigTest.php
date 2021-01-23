<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Support\Facades\Artisan;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestClasses\ServiceProvider;

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
        $this->assertEquals('value', config('laravel-package-tools.key'));
    }

    /** @test */
    public function it_can_publish_the_config_file()
    {
        $this
            ->artisan('vendor:publish --tag=laravel-package-tools-config')
            ->assertExitCode(0);

        $this->assertFileExists(config_path('laravel-package-tools.php'));
    }
}
