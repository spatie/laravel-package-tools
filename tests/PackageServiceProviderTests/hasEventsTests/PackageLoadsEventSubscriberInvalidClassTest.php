<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsEventSubscriberInvalidClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventSubscribers('Invalid_class');
    }
}

uses(PackageLoadsEventSubscriberInvalidClassTest::class);

it("throws an exception for an invalid Event Subscriber class", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "hasEventSubscribers: Class 'Invalid_class' does not exist in package laravel-package-tools");
