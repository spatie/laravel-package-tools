<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasProviderTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishableProviderInvalidProviderTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider('InvalidServiceProvider');
    }
}

uses(PackagePublishableProviderInvalidProviderTest::class);

it("throws an exception on an serviceprovider without a matching file")
    ->group('provider')
    ->throws(
        InvalidPackage::class,
        "publishesServiceProvider: File '../resources/stubs/InvalidServiceProvider.php.stub' does not exist in package laravel-package-tools"
    );
