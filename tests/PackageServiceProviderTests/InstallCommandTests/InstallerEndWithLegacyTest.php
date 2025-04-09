<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use function PHPUnit\Framework\assertEquals;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

beforeEach(function () {
    $this->stringFromEnd = '';
});

trait InstallerEndWithLegacyTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->endWith(function (InstallCommand $installCommand) {
                    $this->stringFromEnd = "set by {$installCommand->getName()}";
                });
            });
    }
}

uses(InstallerEndWithLegacyTest::class);

it('can execute the end with', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertEquals('set by package-tools:install', $this->stringFromEnd);
});
