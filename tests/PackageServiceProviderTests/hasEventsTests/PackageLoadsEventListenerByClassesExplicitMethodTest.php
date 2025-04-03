<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerByClassesExplicitMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerByClasses(TestEvent::class, TestListener::class, 'respond');
    }
}

uses(PackageLoadsEventListenerByClassesExplicitMethodTest::class);

it("registers Event listeners by classes with explicit method", function () {
    Event::assertListening(TestEvent::class, [TestListener::class, 'respond']);
})->group('events');
