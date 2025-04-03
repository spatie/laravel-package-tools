<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackageLoadsMigrationsByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->loadsMigrationsByPath();
    }
}

uses(PackageLoadsMigrationsByPathDefaultTest::class);

$expectPublished = [
];
$expectLoaded = [
    'create_table_discover_normal',
    'create_table_explicit_normal',
    'folder/create_table_subfolder_explicit_normal',
    'folder/create_table_subfolder_discover_normal',
];

it("publishes only migrations by path", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations');

it("loads only the non-stub migrations by path for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations');
