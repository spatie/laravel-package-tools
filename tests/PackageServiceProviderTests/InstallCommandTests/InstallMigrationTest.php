<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait InstallMigrationTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasMigration('create_table_explicit_normal')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishMigrations();
            });
    }
}

uses(InstallMigrationTest::class);

it('can install the migrations', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    expect(true)->toHaveMigrationsPublished('create_table_explicit_normal');
});
