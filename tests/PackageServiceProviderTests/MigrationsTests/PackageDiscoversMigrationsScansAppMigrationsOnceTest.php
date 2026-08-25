<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\MigrationsTests;

use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;

trait PackageDiscoversMigrationsScansAppMigrationsOnceTest
{
    public function configurePackage(Package $package)
    {
        File::partialMock()
            ->shouldReceive('glob')
            ->once()
            ->with(database_path('migrations/./*.php'))
            ->passthru();

        $package
            ->name('laravel-package-tools')
            ->discoversMigrations();
    }
}

uses(PackageDiscoversMigrationsScansAppMigrationsOnceTest::class);

it('scans the app migrations directory only once while discovering migrations', function () {
    expect(true)->toBeTrue();
})->group('migrations');
