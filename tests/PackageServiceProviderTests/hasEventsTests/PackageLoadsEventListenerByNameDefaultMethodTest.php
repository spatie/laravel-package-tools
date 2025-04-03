<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerByNameDefaultMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByName("TestEvent", TestListener::class);
    }
}

uses(PackageLoadsEventListenerByNameDefaultMethodTest::class);

it("registers Event listeners by classes with default method", function () {
    Event::assertListening("TestEvent", [TestListener::class, 'handle']);
})->group('events');
