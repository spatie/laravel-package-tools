<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertFileExists;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigureMultiplePackageMigrationsTest {
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasMigrations(['create_laravel_package_tools_table'])
            ->hasMigrations('create_other_laravel_package_tools_table', 'create_third_laravel_package_tools_table')
            ->hasMigration('folder/create_laravel_package_tools_table_in_the_folder');
    }
}

uses(ConfigureMultiplePackageMigrationsTest::class);

test('it can publish multiple migrations', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertFileExists(database_path('migrations/2020_01_01_000001_create_laravel_package_tools_table.php'));
    assertFileExists(database_path('migrations/2020_01_01_000002_create_other_laravel_package_tools_table.php'));
    assertFileExists(database_path('migrations/2020_01_01_000003_create_third_laravel_package_tools_table.php'));
    assertFileExists(database_path('migrations/folder/2020_01_01_000004_create_laravel_package_tools_table_in_the_folder.php'));
});
