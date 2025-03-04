<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Closure;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerAnonymousQueueableTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerQueueableAnonymous(function (TestEvent $event) {
                //
            });
    }
}

uses(PackageEventListenerAnonymousQueueableTest::class);

it("registers Anonymous Queueable Event listeners", function () {
    Event::assertListening(TestEvent::class, Closure::class);
})->group('events');
