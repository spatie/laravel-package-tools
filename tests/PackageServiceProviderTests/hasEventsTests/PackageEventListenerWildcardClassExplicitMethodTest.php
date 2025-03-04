<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageEventListenerWildcardClassExplicitMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerWildcardByClass('test.*', TestListener::class, 'respondWildcard');
    }
}

uses(PackageEventListenerWildcardClassExplicitMethodTest::class);

it("registers Wildcard listeners by class with explicit method", function () {
    Event::assertListening('test.test', [TestListener::class, 'respondWildcard']);
})->group('events');
