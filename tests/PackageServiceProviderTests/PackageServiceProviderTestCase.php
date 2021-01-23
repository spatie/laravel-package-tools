<?php


namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;


use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestClasses\ServiceProvider;

abstract class PackageServiceProviderTestCase extends TestCase
{
    public function setUp(): void
    {
        ServiceProvider::$configurePackageUsing = function(Package $package) {
            $this->configurePackage($package);
        };

        parent::setUp();
    }

    abstract function configurePackage(Package $package);

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}
