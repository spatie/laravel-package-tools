<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Support\Facades\File;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProvider;
use function Spatie\PestPluginTestTime\testTime;
use Symfony\Component\Finder\SplFileInfo;

abstract class PackageServiceProviderTestCase extends TestCase
{
    protected function setUp(): void
    {
        ServiceProvider::$configurePackageUsing = function (Package $package) {
            $this->configurePackage($package);
        };

        parent::setUp();

        testTime()->freeze('2020-01-01 00:00:00');

        $this->deletePublishedFiles();
        $this->createApplication();
    }

    protected function tearDown(): void
    {
        $this->deletePublishedFiles();
        $this->deleteMigrations();

        parent::tearDown();
    }

    abstract public function configurePackage(Package $package);

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function deletePublishedFiles(): self
    {
        $configPath = config_path('package-tools.php');

        if (file_exists($configPath)) {
            unlink($configPath);
        }

        $configPath = config_path('alternative-config.php');

        if (file_exists($configPath)) {
            unlink($configPath);
        }

        collect(File::allFiles(database_path('migrations')))
            ->each(function (SplFileInfo $file) {
                unlink($file->getPathname());
            });

        collect(File::allFiles(app_path('Providers')))
            ->each(function (SplFileInfo $file) {
                unlink($file->getPathname());
            });

        /* Clear publishes from previous tests */
        ServiceProvider::$publishes[ServiceProvider::class] = [];

        return $this;
    }

    protected function deleteMigrations(): self
    {
        /* Clear migrations from previous tests */
        $migrator = app('migrator');
        $reflection = new \ReflectionClass($migrator::class);
        $property = $reflection->getProperty('paths');
        $property->setAccessible(true);
        $property->setvalue($migrator, []);

        return $this;
    }
}
