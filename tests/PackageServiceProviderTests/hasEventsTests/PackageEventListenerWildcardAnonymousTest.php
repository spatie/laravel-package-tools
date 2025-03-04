<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Closure;
use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;

trait PackageEventListenerWildcardAnonymousTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasEventListenerWildcardAnonymous('test.*', function (string $event, ...$payload) {
                //
            });
    }
}

uses(PackageEventListenerWildcardAnonymousTest::class);

it("registers Wildcard Anonymous Event listeners", function () {
    Event::assertListening('test.test', Closure::class);
})->group('events');
