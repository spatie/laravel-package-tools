<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Spatie\TestTime\TestTime;

class ConfigFileTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishConfigFile();
            });
    }

    /** @test */
    public function it_can_install_the_config_file()
    {
        $configPath = config_path('package-tools.php');

        $this
            ->artisan('package-tools:install')
            ->assertSuccessful();

        $this->assertFileExists($configPath);
    }
}
