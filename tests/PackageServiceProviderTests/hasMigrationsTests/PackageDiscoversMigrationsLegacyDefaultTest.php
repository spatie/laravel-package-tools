<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackageDiscoversMigrationsLegacyDefaultTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->discoversMigrations()
            ->runsMigrations();
    }
}

uses(PackageDiscoversMigrationsLegacyDefaultTest::class);

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
$expectLoaded = [
    'create_table_discover_normal',
    'create_table_explicit_normal',
    'folder/create_table_subfolder_discover_normal',
    'folder/create_table_subfolder_explicit_normal',
];

it("publishes only all migrations by discoversMigrations", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations', 'legacy');

it("does not overwrite an existing migration by discoversMigrations", function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(true)->toHaveExpectedMigrationsPublished('2020_01_01_000001_create_laravel_package_tools_table');

    $filePath = database_path('migrations/2020_01_01_000001_create_laravel_package_tools_table');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect($filePath)->toHaveContentsMatching('modified');
})->group('migrations', 'legacy');

it("loads only the discovered non-stub migrations by discoversMigrations for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations', 'legacy');
