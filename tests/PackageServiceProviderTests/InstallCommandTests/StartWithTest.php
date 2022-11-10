<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertEquals;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigureStartWithTest {
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->startWith(function (InstallCommand $installCommand) {
                    $this->stringFromStart = "set by {$installCommand->getName()}";
                });
            });
    }
}

uses(ConfigureStartWithTest::class);

beforeEach(function () {
    $this->stringFromStart = '';
});

test('it can execute the start with', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertEquals('set by package-tools:install', $this->stringFromStart);
});
