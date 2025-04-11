<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\MigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackageHasMigrationsLegacyPublishOnlyTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasMigration(migrationFileName: 'create_table_explicit_normal')
            ->hasMigrations(
                'create_table_explicit_stub',
                'folder/create_table_subfolder_explicit_stub',
                'folder/create_table_subfolder_explicit_normal'
            )
            ->hasMigration(migrationFileName: '2025_03_14_011123_create_laravel_package_tools_table_stub');
    }
}

uses(PackageHasMigrationsLegacyPublishOnlyTest::class);

$expectPublished = [
    'create_table_explicit_normal',
    'create_table_explicit_stub',
    'folder/create_table_subfolder_explicit_normal',
    'folder/create_table_subfolder_explicit_stub',
    'create_laravel_package_tools_table_stub',
];
$expectLoaded = [
];

it("publishes only the explicitly listed migrations", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations', 'legacy');

it("doesn't overwrite an existing migration", function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    $filePath = database_path('migrations/2020_01_01_000001_create_table_explicit_normal.php');

    expect(true)->toHaveExpectedMigrationsPublished('2020_01_01_000001_create_table_explicit_normal');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect($filePath)->toHaveContentsMatching('modified');
})->group('migrations', 'legacy');

it("does overwrite an existing migration with 'artisan migrate --force'", function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(true)->toHaveExpectedMigrationsPublished('2020_01_01_000001_create_table_explicit_normal');

    $filePath = database_path('migrations/2020_01_01_000001_create_table_explicit_normal.php');

    file_put_contents($filePath, 'overwritten');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations  --force')
        ->assertSuccessful();

    expect($filePath)->toHaveContentsMatchingFile(__DIR__.'/../../TestPackage/database/migrations/create_table_explicit_normal.php');
})->group('migrations', 'legacy');

it("doesn't load any non-stub migrations for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations', 'legacy');
