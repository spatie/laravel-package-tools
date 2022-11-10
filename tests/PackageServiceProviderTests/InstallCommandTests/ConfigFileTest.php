<?php

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertFileExists;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigureConfigFileTest {
    public function configurePackage(Package $package)
    {
        testTime()->freeze();

        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishConfigFile();
            });
    }
}

uses(ConfigureConfigFileTest::class);

test('it can install the config file', function () {
    $configPath = config_path('package-tools.php');

    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertFileExists($configPath);
});
