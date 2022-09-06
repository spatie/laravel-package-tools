<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Spatie\TestTime\TestTime;

class MigrationTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasMigration('create_another_laravel_package_tools_table')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishMigrations();
            });
    }

    /** @test */
    public function it_can_install_the_migrations()
    {
        $this
            ->artisan('package-tools:install')
            ->assertSuccessful();

        $this->assertMigrationPublished('create_another_laravel_package_tools_table.php');
    }
}
