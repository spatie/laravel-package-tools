<?php

use function PHPUnit\Framework\assertEquals;
use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigurePackageMigrationTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasMigrations('create_table_explicit_normal', 'create_table_explicit_stub')
            ->hasMigration('folder/create_table_subfolder_explicit_stub')
            ->hasMigration('folder/create_table_subfolder_explicit_normal')
            ->runsMigrations();
    }
}

uses(ConfigurePackageMigrationTest::class);

$expectPublished = [
    'create_table_explicit_normal',
    'create_table_explicit_stub',
    'folder/create_table_subfolder_explicit_normal',
    'folder/create_table_subfolder_explicit_stub',
];
$expectNotPublished = [
    'create_table_discover_normal',
    'create_table_discover_stub',
    'non_migration_text_file',
    'folder/create_table_subfolder_discover_normal',
    'folder/create_table_subfolder_discover_stub',
    'folder/subfolder_non_migration_text_file',
];
$expectLoaded = [
    'create_table_explicit_normal',
    'folder/create_table_subfolder_explicit_normal',
];
$expectNotLoaded = [
    'create_table_explicit_stub',
    'create_table_discover_normal',
    'create_table_discover_stub',
    'non_migration_text_file',
    'folder/create_table_subfolder_explicit_stub',
    'folder/create_table_subfolder_discover_normal',
    'folder/create_table_subfolder_discover_stub',
    'folder/subfolder_non_migration_text_file',
];


it('publishes the explicitly listed migrations', function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsPublished($expectPublished);
});

it('doesn\'t publish the non-listed migrations', function () use ($expectNotPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsNotPublished($expectNotPublished);
});

it('doesn\'t overwrite an existing migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $filePath = database_path('migrations/2020_01_01_000001_create_table_explicit_normal.php');

    assertMigrationsPublished('2020_01_01_000001_create_table_explicit_normal');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $this->assertStringEqualsFile($filePath, 'modified');
});

it('does overwrite an existing migration with "artisan migrate --force"', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $filePath = database_path('migrations/2020_01_01_000001_create_table_explicit_normal.php');

    assertMigrationsPublished('2020_01_01_000001_create_table_explicit_normal');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations  --force')
        ->assertExitCode(0);

    $this->assertStringEqualsFile(
        $filePath,
        file_get_contents(__DIR__.'/../../TestPackage/database/migrations/create_table_explicit_normal.php')
    );
});

it('loads the explicitly listed non-stub migrations for "artisan migrate"', function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsLoaded(__DIR__ . '/../../TestPackage/database/migrations', $expectLoaded);
});

it('doesn\'t load the non-listed migrations or stub files for "artisan migrate"', function () use ($expectNotLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsNotLoaded(__DIR__ . '/../../TestPackage/database/migrations', $expectNotLoaded);
});
