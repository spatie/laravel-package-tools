<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasServiceProviderTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderByNameInvalidProviderTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvidersByName('InvalidServiceProvider');
    }
}

uses(PackagePublishesServiceProviderByNameInvalidProviderTest::class);

it("throws an exception on an serviceprovider without a matching file")
    ->group('provider')
    ->throws(
        InvalidPackage::class,
        "publishesServiceProvidersByName: File '../resources/stubs/InvalidServiceProvider.php.stub' does not exist in package laravel-package-tools"
    );
