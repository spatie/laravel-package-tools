<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackagePublishesMigrationsByPathTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->publishesMigrationsByPath('../database/migrations');
    }
}

uses(PackagePublishesMigrationsByPathTest::class);

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
];

it("publishes only migrations by path", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations');

it("doesn't overwrite an existing migrations by path", function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(true)->toHaveExpectedMigrationsPublished('2020_01_01_000001_create_laravel_package_tools_table');

    $filePath = database_path('migrations/2020_01_01_000001_create_laravel_package_tools_table.php');

    file_put_contents($filePath, 'modified');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect($filePath)->toHaveContentsMatching('modified');
})->group('migrations');

it("does overwrite an existing migration by path with 'artisan migrate --force'", function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(true)->toHaveExpectedMigrationsPublished('2020_01_01_000001_create_laravel_package_tools_table');

    $filePath = database_path('migrations/2020_01_01_000001_create_laravel_package_tools_table.php');

    file_put_contents($filePath, 'overwritten');

    $this
        ->artisan('vendor:publish --tag=package-tools-migrations  --force')
        ->assertSuccessful();

    expect($filePath)->toHaveContentsMatchingFile(__DIR__.'/../../TestPackage/database/migrations/2025_03_14_011123_create_laravel_package_tools_table.php.stub');
})->group('migrations');

it("loads only the non-stub migrations by path for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations');
