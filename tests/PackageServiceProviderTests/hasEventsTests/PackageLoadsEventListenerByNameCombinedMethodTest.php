<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerByNameCombinedMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByName("TestEvent", TestListener::class . '@respond');
    }
}

uses(PackageLoadsEventListenerByNameCombinedMethodTest::class);

it("registers Event listeners by classes with class@method", function () {
    Event::assertListening("TestEvent", TestListener::class . '@respond');
})->group('events');
