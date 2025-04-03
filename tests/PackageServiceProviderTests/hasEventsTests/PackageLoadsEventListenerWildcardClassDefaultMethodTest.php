<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerWildcardClassDefaultMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerWildcardByClass('test.*', TestListener::class);
    }
}

uses(PackageLoadsEventListenerWildcardClassDefaultMethodTest::class);

it("registers Wildcard listeners by class with default method", function () {
    Event::assertListening('test.test', [TestListener::class, 'handleWildcard']);
})->group('events');
