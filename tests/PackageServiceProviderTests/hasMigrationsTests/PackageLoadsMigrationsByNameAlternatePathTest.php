<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackageLoadsMigrationsByNameAlternatePathTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->loadsMigrationsByName('create_table_alt_explicit_stub', 'create_table_alt_explicit_normal')
            ->setMigrationsByNamePath('../database/migrations_alt');
    }
}

uses(PackageLoadsMigrationsByNameAlternatePathTest::class);

$expectPublished = [
];
$expectLoaded = [
    'create_table_alt_explicit_normal',
];

it("publishes the explicitly listed migrations", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations');

it("loads only the explicitly listed non-stub migrations for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations');
