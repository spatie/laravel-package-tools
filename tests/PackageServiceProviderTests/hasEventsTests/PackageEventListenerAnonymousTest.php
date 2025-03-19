<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Closure;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;

trait PackageEventListenerAnonymousTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerAnonymous(function (TestEvent $event) {
                //
            });
    }
}

uses(PackageEventListenerAnonymousTest::class);

it("registers Anonymous Event listeners", function () {
    Event::assertListening(TestEvent::class, Closure::class);
})->group('events');
