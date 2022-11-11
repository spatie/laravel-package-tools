<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderConcreteTestCase;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Spatie\TestTime\TestTime;

beforeAll(function () {
    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $package = new Package();

    $package
        ->name('laravel-package-tools')
        ->hasConfigFile()
        ->hasInstallCommand(function (InstallCommand $command) {
            $command->startWith(function (InstallCommand $installCommand) {
                PackageServiceProviderConcreteTestCase::setUtilityField("set by {$installCommand->getName()}");
            });
        });
    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_execute_the_start_wit', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    $this->assertEquals('set by package-tools:install', PackageServiceProviderConcreteTestCase::getUtilityField());
});
