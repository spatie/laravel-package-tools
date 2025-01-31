<?php

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigurePackageMigrationTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasMigration('create_another_laravel_package_tools_table')
            ->hasMigration('create_regular_laravel_package_tools_table')
            ->runsMigrations();
    }
}

uses(ConfigurePackageMigrationTest::class);

it('can publish the stubbed migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->doesntExpectOutput('hey')
        ->assertExitCode(0);

    assertMigrationPublished('create_another_laravel_package_tools_table.php');
});

it('can publish the non-stubbed migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationPublished('create_regular_laravel_package_tools_table.php');
});

it('does not overwrite the existing migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $filePath = database_path('migrations/2020_01_01_000001_create_another_laravel_package_tools_table.php');

    assertMigrationPublished('create_another_laravel_package_tools_table.php');


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

    $filePath = database_path('migrations/2020_01_01_000001_create_another_laravel_package_tools_table.php');

    $this->assertFileExists($filePath);

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations  --force')
        ->assertExitCode(0);

    $this->assertStringEqualsFile(
        $filePath,
        file_get_contents(__DIR__.'/../../TestPackage/database/migrations/create_another_laravel_package_tools_table.php.stub')
    );
});

it('can run migrations which registers them', function () {
    /** @var \Illuminate\Database\Migrations\Migrator $migrator */
    $migrator = app('migrator');

    $this->assertCount(1, $migrator->paths());
    $this->assertStringContainsString('laravel_package_tools', $migrator->paths()[0]);
});
