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
    $configFile = config_path('package-tools.php');
    expect($configFile)->not->toBeFileOrDirectory();

    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    expect($configFile)->toBeFile();
});
