<?php

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigureGuessingPackageMigrationTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasMigrations()
            ->runsMigrations();
    }
}

uses(ConfigureGuessingPackageMigrationTest::class);


it('can guess and publish multiple migrations', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);
    assertMigrationPublished('migrations/create_regular_laravel_package_tools_table.php');
});

it('can publish the migration without being stubbed', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationPublished('create_regular_laravel_package_tools_table.php');
});

it('does not overwrite the existing migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationPublished('create_regular_laravel_package_tools_table.php');

    $filePath = database_path('migrations/create_regular_laravel_package_tools_table.php');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $this->assertStringEqualsFile($filePath, 'modified');
});

it('does overwrite the existing migration with force', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $filePath = database_path('migrations/create_regular_laravel_package_tools_table.php');

    $this->assertFileExists($filePath);

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations  --force')
        ->assertExitCode(0);

    $this->assertStringEqualsFile(
        $filePath,
        file_get_contents(__DIR__.'/../TestPackage/database/migrations/create_regular_laravel_package_tools_table.php')
    );
});
