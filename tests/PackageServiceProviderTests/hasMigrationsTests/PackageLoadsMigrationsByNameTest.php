<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackageLoadsMigrationsByNameTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->loadsMigrationsByName('create_table_explicit_normal', 'create_table_explicit_stub')
            ->loadsMigrationsByName('folder/create_table_subfolder_explicit_stub')
            ->loadsMigrationsByName('folder/create_table_subfolder_explicit_normal');
    }
}

uses(PackageLoadsMigrationsByNameTest::class);

$expectPublished = [
];
$expectLoaded = [
    'create_table_explicit_normal',
    'folder/create_table_subfolder_explicit_normal',
];

it("publishes only the explicitly listed migrations", function () use ($expectPublished) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsPublished($expectPublished);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsPublished($expectPublished);
})->group('migrations');

it("loads only the explicitly listed non-stub migrations for 'artisan migrate'", function () use ($expectLoaded) {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveExpectedMigrationsLoaded($expectLoaded);
    expect(__DIR__ . '/../../TestPackage/database/migrations')->toHaveOnlyExpectedMigrationsLoaded($expectLoaded);
})->group('migrations');
