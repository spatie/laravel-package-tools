<?php

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait ConfigureMigrationTest
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

uses(ConfigureMigrationTest::class);

it('can install the migrations', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertMigrationsPublished('create_table_explicit_normal');
});
