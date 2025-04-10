<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait InstallerConfigFileLegacyTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishConfigFile();
            });
    }
}

uses(InstallerConfigFileLegacyTest::class);

it('can install the config file', function () {
    $configPath = config_path('package-tools.php');

    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertFileExists($configPath);
});
