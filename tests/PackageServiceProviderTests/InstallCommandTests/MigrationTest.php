<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderConcreteTestCase;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;

beforeAll(function () {

    $package = new Package();

    $package
        ->name('laravel-package-tools')
        ->hasConfigFile()
        ->hasMigration('create_another_laravel_package_tools_table')
        ->hasInstallCommand(function (InstallCommand $command) {
            $command->publishMigrations();
        });

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_install_the_migrations',function(){
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    $this->assertMigrationPublished('create_another_laravel_package_tools_table.php');
});
