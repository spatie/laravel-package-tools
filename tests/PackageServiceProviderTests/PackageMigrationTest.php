<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\TestTime\TestTime;

class PackageMigrationTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasMigration('create_laravel_package_tools_table');
    }

    /** @test */
    public function it_can_publish_the_migration()
    {
        $this
            ->artisan('vendor:publish --tag=laravel-package-tools-migrations')
            ->assertExitCode(0);

        $this->assertFileExists(database_path('migrations/2020_01_01_000000_create_laravel_package_tools_table.php'));
    }
}
