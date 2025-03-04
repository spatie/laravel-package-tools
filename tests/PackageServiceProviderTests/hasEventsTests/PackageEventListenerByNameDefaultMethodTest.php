<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerByNameDefaultMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerByName("TestEvent", TestListener::class);
    }
}

uses(PackageEventListenerByNameDefaultMethodTest::class);

it("registers Event listeners by classes with default method", function () {
    Event::assertListening("TestEvent", [TestListener::class, 'handle']);
})->group('events');
