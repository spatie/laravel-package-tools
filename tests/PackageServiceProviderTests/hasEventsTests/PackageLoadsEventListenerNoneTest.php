<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Events\TestEvent;

trait PackageLoadsEventListenerNoneTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');
    }
}

uses(PackageLoadsEventListenerNoneTest::class);

it("hasn't any registered listeners by default", function () {
    expect(Event::hasListeners(TestEvent::class))->toBeFalse();
})->group('events');
