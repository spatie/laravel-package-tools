<?php


namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Filesystem\Filesystem;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProvider;

abstract class PackageServiceProviderTestCase extends TestCase
{
    public function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            (new Filesystem)->cleanDirectory(database_path('migrations'));
        });

        $this->beforeApplicationDestroyed(function () {
            (new Filesystem)->cleanDirectory(database_path('migrations'));
        });

        ServiceProvider::$configurePackageUsing = function (Package $package) {
            $this->configurePackage($package);
        };

        parent::setUp();
    }

    abstract public function configurePackage(Package $package);

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
