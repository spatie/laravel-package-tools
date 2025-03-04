<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Closure;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerWildcardClassDefaultMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerWildcardByClass('test.*', TestListener::class);
    }
}

uses(PackageEventListenerWildcardClassDefaultMethodTest::class);

it("registers Wildcard listeners by class with default method", function () {
    Event::assertListening('test.test', [TestListener::class, 'handleWildcard']);
})->group('events');
