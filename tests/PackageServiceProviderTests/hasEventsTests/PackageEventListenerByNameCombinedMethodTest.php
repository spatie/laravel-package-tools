<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerByNameCombinedMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerByName("TestEvent", TestListener::class . '@respond');
    }
}

uses(PackageEventListenerByNameCombinedMethodTest::class);

it("registers Event listeners by classes with class@method", function () {
    Event::assertListening("TestEvent", TestListener::class . '@respond');
})->group('events');
