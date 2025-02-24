<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait InstallConfigFileTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishConfigFile();
            });
    }
}

uses(InstallConfigFileTest::class);

it('can install the config file', function () {
    $configPath = config_path('package-tools.php');

    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    $this->assertFileExists($configPath);
});
