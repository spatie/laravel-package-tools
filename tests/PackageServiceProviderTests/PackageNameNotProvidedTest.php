<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait PackageNameNotProvidedTest
{
    public function configurePackage(Package $package)
    {
        //
    }
}

uses(PackageNameNotProvidedTest::class);

it('will give an exception when a name is NOT set', function () {
    $this->reThrowException();
})
    ->throws(InvalidPackage::class, 'This package does not have a name. You can set one with `$package->name("yourName")`');
