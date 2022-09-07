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
            ->hasMigration('create_another_laravel_package_tools_table')
            ->hasMigration('create_regular_laravel_package_tools_table')
            ->runsMigrations();
    }

    /** @test */
    public function it_can_publish_the_migration()
    {
        $this
            ->artisan('vendor:publish --tag=package-tools-migrations')
            ->doesntExpectOutput('hey')
            ->assertExitCode(0);

        $this->assertMigrationPublished('create_another_laravel_package_tools_table.php');
    }

    /** @test */
    public function it_can_publish_the_migration_without_being_stubbed()
    {
        $this
            ->artisan('vendor:publish --tag=package-tools-migrations')
            ->assertExitCode(0);

        $this->assertMigrationPublished('create_regular_laravel_package_tools_table.php');
    }

    /** @test */
    public function it_does_not_overwrite_the_existing_migration()
    {
        $this
            ->artisan('vendor:publish --tag=package-tools-migrations')
            ->assertExitCode(0);

        $filePath = database_path('migrations/2020_01_01_000001_create_another_laravel_package_tools_table.php');

        $this->assertMigrationPublished('create_another_laravel_package_tools_table.php');


        file_put_contents($filePath, 'modified');

        $this
            ->artisan('vendor:publish --tag=package-tools-migrations')
            ->assertExitCode(0);

        $this->assertStringEqualsFile($filePath, 'modified');
    }

    /** @test */
    public function it_does_overwrite_the_existing_migration_with_force()
    {
        $this
            ->artisan('vendor:publish --tag=package-tools-migrations')
            ->assertExitCode(0);

        $filePath = database_path('migrations/2020_01_01_000001_create_another_laravel_package_tools_table.php');

        $this->assertFileExists($filePath);

        file_put_contents($filePath, 'modified');

        $this
            ->artisan('vendor:publish --tag=package-tools-migrations  --force')
            ->assertExitCode(0);

        $this->assertStringEqualsFile(
            $filePath,
            file_get_contents(__DIR__.'/../TestPackage/database/migrations/create_another_laravel_package_tools_table.php.stub')
        );
    }

    /** @test * */
    public function it_can_run_migrations_which_registers_them()
    {
        /** @var \Illuminate\Database\Migrations\Migrator $migrator */
        $migrator = app('migrator');

        $this->assertCount(2, $migrator->paths());
        $this->assertStringContainsString('laravel_package_tools', $migrator->paths()[0]);
    }
}
