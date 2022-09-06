<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestClasses\TestCommand;

class PackagePublishableProviderTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider('MyPackageServiceProvider');
    }

    /** @test */
    public function it_can_publish_a_service_provider()
    {
        $providerPath = app_path('Providers/MyPackageServiceProvider.php');

        $this->assertFileDoesNotExist($providerPath);

        $this
            ->artisan('vendor:publish --tag=package-tools-provider')
            ->assertSuccessful();

        $this->assertFileExists($providerPath);

    }
}
