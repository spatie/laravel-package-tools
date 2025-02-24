<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait InstallAssetsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishAssets();
            });
    }
}

uses(InstallAssetsTest::class);

it('can install the assets', function () {
    $assetPath = public_path('/vendor/package-tools');

    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    $this->assertDirectoryExists($assetPath);
});
