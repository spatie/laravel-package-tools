<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;

trait PackageLoadsEventListenerByClassesInvalidListenerClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByClasses(TestEvent::class, "Invalid_class");
    }
}

uses(PackageLoadsEventListenerByClassesInvalidListenerClassTest::class);

it("throws an exception when an invalid Listener class is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "loadsEventListenerByClasses: Class 'Invalid_class' does not exist in package laravel-package-tools");
