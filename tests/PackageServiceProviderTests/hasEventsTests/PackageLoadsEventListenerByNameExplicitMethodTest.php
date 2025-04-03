<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerByNameExplicitMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByName("TestEvent", TestListener::class, 'respond');
    }
}

uses(PackageLoadsEventListenerByNameExplicitMethodTest::class);

it("registers Event listeners by classes with explicit method", function () {
    Event::assertListening("TestEvent", [TestListener::class, 'respond']);
})->group('events');
