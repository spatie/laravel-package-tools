<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use function PHPUnit\Framework\assertDirectoryExists;
use Spatie\LaravelPackageTools\Commands\Concerns;
use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait InstallerAssetsLegacyTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasAssets()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishAssets();
            });
    }
}

uses(InstallerAssetsLegacyTest::class);

it('can install the assets', function () {
    $assetPath = public_path('/vendor/package-tools');

    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertDirectoryExists($assetPath);
});
