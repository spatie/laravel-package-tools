<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageNameNotProvidedTest
{
    public function configurePackage(Package $package)
    {
        //
    }
}

uses(PackageNameNotProvidedTest::class);

it("will throw an exception when a name is NOT set")
    ->group('base')
    ->throws(InvalidPackage::class, 'This package does not have a name. You can set one with `$package->name("yourName")`');
