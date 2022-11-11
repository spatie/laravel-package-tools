<?php

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait ConfigureMigrationTest {
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

}

uses(ConfigureMigrationTest::class);

it('can install the migrations', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertMigrationPublished('create_another_laravel_package_tools_table.php');
});
