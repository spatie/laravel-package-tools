<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerByNameExplicitMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerByName("TestEvent", TestListener::class, 'respond');
    }
}

uses(PackageEventListenerByNameExplicitMethodTest::class);

it("registers Event listeners by classes with explicit method", function () {
    Event::assertListening("TestEvent", [TestListener::class, 'respond']);
})->group('events');
