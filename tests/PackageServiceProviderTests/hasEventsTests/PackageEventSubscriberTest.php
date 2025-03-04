<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestSubscriber;

trait PackageEventSubscriberTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventSubscribers(TestSubscriber::class);
    }
}

uses(PackageEventSubscriberTest::class);

it("registers Event Subscribers by class", function () {
    Event::assertListening(TestEvent::class, [TestSubscriber::class, 'handleTestEvent']);
})->group('events');
