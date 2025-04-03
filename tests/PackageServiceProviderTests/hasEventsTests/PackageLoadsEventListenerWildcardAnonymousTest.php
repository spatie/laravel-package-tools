<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Closure;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsEventListenerWildcardAnonymousTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerWildcardAnonymous('test.*', function (string $event, ...$payload) {
                //
            });
    }
}

uses(PackageLoadsEventListenerWildcardAnonymousTest::class);

it("registers Wildcard Anonymous Event listeners", function () {
    Event::assertListening('test.test', Closure::class);
})->group('events');
