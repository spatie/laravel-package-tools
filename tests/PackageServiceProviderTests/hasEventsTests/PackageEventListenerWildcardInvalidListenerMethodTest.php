<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageEventListenerWildcardInvalidListenerMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerWildcardByClass("test.*", TestListener::class, "Invalid_method");
    }
}

uses(PackageEventListenerWildcardInvalidListenerMethodTest::class);

it("throws an exception when an invalid Listener method is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "hasEventListenerWildcardByClass: Listener 'TestListener' does not have method 'Invalid_method' in package laravel-package-tools");
