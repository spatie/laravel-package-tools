<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageDiscoversMigrationsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->discoversMigrations()
            ->runsMigrations();
    }
}

uses(PackageDiscoversMigrationsTest::class);

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
        ->assertSuccessful();

    expect(true)->toHaveMigrationsPublished($expectPublished);
});

it('doesn\'t publish non-migration files', function () use ($expectNotPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(true)->toHaveMigrationsNotPublished($expectNotPublished);
});

it('does not overwrite an existing migration', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(true)->toHaveMigrationsPublished('2020_01_01_000001_create_table_discover_normal');

    $filePath = database_path('migrations/2020_01_01_000001_create_table_discover_normal.php');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect($filePath)->toHaveContentsMatching('modified');
});

it('loads the discovered non-stub migrations for "artisan migrate"', function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveMigrationsLoaded($expectLoaded);
});

it('doesn\'t load the stub migrations for "artisan migrate"', function () use ($expectNotLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveMigrationsNotLoaded($expectNotLoaded);
});
