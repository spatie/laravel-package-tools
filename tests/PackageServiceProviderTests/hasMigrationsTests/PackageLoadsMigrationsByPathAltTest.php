<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackageLoadsMigrationsByPathAltTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->loadsMigrationsByPath('../database/migrations_alt');
    }
}

uses(PackageLoadsMigrationsByPathAltTest::class);

$expectPublished = [
];
$expectLoaded = [
    'create_table_alt_explicit_normal',
    'create_table_alt_discover_normal',
];

it("publishes only migrations by path", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations');

it("loads only the non-stub migrations by path for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations_alt')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations');
