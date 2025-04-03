<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsEventListenerByNameInvalidListenerClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByName("TestEvent", "Invalid_class");
    }
}

uses(PackageLoadsEventListenerByNameInvalidListenerClassTest::class);

it("throws an exception when an invalid Listener class is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "loadsEventListenerByName: Class 'Invalid_class' does not exist in package laravel-package-tools");
