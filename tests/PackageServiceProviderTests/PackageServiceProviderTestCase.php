<?php


namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProvider;
use Spatie\TestTime\TestTime;
use Symfony\Component\Finder\SplFileInfo;

abstract class PackageServiceProviderTestCase extends TestCase
{
    protected function setUp(): void
    {
        ServiceProvider::$configurePackageUsing = function (Package $package) {
            $this->configurePackage($package);
        };

        parent::setUp();

        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $this->deletePublishedFiles();
    }

    abstract public function configurePackage(Package $package);

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    public function assertMigrationPublished(string $fileName): self
    {
        $published = collect(File::allFiles(database_path('migrations')))
            ->contains(function (SplFileInfo $file) use ($fileName) {
                return Str::endsWith($file->getPathname(), $fileName);
            });

        $this->assertTrue($published);

        return $this;
    }

    protected function deletePublishedFiles(): self
    {
        $configPath = config_path('package-tools.php');

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

        return $this;
    }
}
