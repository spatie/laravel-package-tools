<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerByNameInvalidListenerClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerByName("TestEvent", "Invalid_class");
    }
}

uses(PackageEventListenerByNameInvalidListenerClassTest::class);

it("throws an exception when an invalid Listener class is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "hasEventListenerByName: Class 'Invalid_class' does not exist in package laravel-package-tools");
