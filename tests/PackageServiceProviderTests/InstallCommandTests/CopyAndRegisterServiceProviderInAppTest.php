<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Spatie\TestTime\TestTime;

class CopyAndRegisterServiceProviderInAppTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->publishesServiceProvider('MyPackageServiceProvider')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->copyAndRegisterServiceProviderInApp();
            });
    }

    /** @test */
    public function it_can_copy_and_register_the_service_provider_in_the_app()
    {
        $this
            ->artisan('package-tools:install')
            ->assertSuccessful();

        $this->assertStringContainsString(
            "App\Providers\MyPackageServiceProvider::class",
            file_get_contents(base_path('config/app.php'))
        );

        $this->restoreAppConfigFile();
    }

    /*
     * If we leave the published config file in,
     * all subsequent tests will fail
     */
    protected function restoreAppConfigFile(): void
    {
        $newContent = str_replace(
            'App\Providers\MyPackageServiceProvider::class,' . PHP_EOL,
            '',
            file_get_contents(base_path('config/app.php'))
        );

        file_put_contents(base_path('config/app.php'), $newContent);
    }
}
