<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerByClassesInvalidListenerClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerByClasses(TestEvent::class, "Invalid_class");
    }
}

uses(PackageEventListenerByClassesInvalidListenerClassTest::class);

it("throws an exception when an invalid Listener class is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "hasEventListenerByClasses: Class 'Invalid_class' does not exist in package laravel-package-tools");
