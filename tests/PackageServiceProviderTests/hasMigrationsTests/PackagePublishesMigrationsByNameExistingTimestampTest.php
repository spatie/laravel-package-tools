<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasMigrationsTests;

use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait PackagePublishesMigrationsByNameExistingTimestampTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->publishesMigrationsByName('2025_03_14_011123_create_laravel_package_tools_table');
    }
}

uses(PackagePublishesMigrationsByNameExistingTimestampTest::class);

it("publishes a stub with an existing timestamp with it removed", function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-migrations')
        ->assertSuccessful();

    expect(database_path('migrations/2020_01_01_000001_create_laravel_package_tools_table.php'))->toBeFile();

})->group('migrations');
