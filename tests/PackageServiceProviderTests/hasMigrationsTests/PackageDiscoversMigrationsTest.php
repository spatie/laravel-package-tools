<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigurePackageDiscoverMigrationsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->discoversMigrations()
            ->runsMigrations();
    }
}

uses(ConfigurePackageDiscoverMigrationsTest::class);

$expectPublished = [
    'create_table_discover_normal',
    'create_table_discover_stub',
    'create_table_explicit_normal',
    'create_table_explicit_stub',
    'folder/create_table_subfolder_explicit_normal',
    'folder/create_table_subfolder_explicit_stub',
    'folder/create_table_subfolder_discover_normal',
    'folder/create_table_subfolder_discover_stub',
];
$expectNotPublished = [
    'non_migration_text_file',
    'folder/subfolder_non_migration_text_file',
];
$expectLoaded = [
    'create_table_explicit_normal',
    'create_table_discover_normal',
    'folder/create_table_subfolder_explicit_normal',
    'folder/create_table_subfolder_discover_normal',
];
$expectNotLoaded = [
    'create_table_explicit_stub',
    'create_table_discover_stub',
    'non_migration_text_file',
    'folder/create_table_subfolder_explicit_stub',
    'folder/create_table_subfolder_discover_stub',
    'folder/subfolder_non_migration_text_file',
];

it('publishes all migrations', function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsPublished($expectPublished);
});

it('doesn\'t publish non-migration files', function () use ($expectNotPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsNotPublished($expectNotPublished);
});

it('does not overwrite an existing migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $filePath = database_path('migrations/2020_01_01_000001_create_table_discover_normal.php');

    assertMigrationsPublished('2020_01_01_000001_create_table_discover_normal');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    $this->assertStringEqualsFile($filePath, 'modified');
});

it('loads the discovered non-stub migrations for "artisan migrate"', function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsLoaded(__DIR__ . '/../../TestPackage/database/migrations', $expectLoaded);
});

it('doesn\'t load the stub migrations for "artisan migrate"', function () use ($expectNotLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertExitCode(0);

    assertMigrationsNotLoaded(__DIR__ . '/../../TestPackage/database/migrations', $expectNotLoaded);
});
