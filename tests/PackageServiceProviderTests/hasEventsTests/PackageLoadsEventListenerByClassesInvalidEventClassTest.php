<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerByClassesInvalidEventClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByClasses("Invalid_class", TestListener::class);
    }
}

uses(PackageLoadsEventListenerByClassesInvalidEventClassTest::class);

it("throws an exception when an invalid Event class is used", function () {
})
    ->group('events')
    ->throws(InvalidPackage::class, "loadsEventListenerByClasses: Class 'Invalid_class' does not exist in package laravel-package-tools");
