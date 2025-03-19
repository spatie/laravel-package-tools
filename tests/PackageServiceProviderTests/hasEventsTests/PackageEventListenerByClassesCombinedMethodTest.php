<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageEventListenerByClassesCombinedMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerByClasses(TestEvent::class, TestListener::class . '@respond');
    }
}

uses(PackageEventListenerByClassesCombinedMethodTest::class);

it("registers Event listeners by classes with class@method", function () {
    Event::assertListening(TestEvent::class, TestListener::class . '@respond');
})->group('events');
