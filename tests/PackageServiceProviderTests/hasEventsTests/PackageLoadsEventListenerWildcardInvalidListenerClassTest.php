<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsEventListenerWildcardInvalidListenerClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerWildcardByClass("test.*", "Invalid_class");
    }
}

uses(PackageLoadsEventListenerWildcardInvalidListenerClassTest::class);

it("throws an exception when an invalid Listener class is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "loadsEventListenerWildcardByClass: Class 'Invalid_class' does not exist in package laravel-package-tools");
