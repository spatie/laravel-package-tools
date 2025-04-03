<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasEventsTests;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Listeners\TestListener;

trait PackageLoadsEventListenerWildcardClassCombinedMethodTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsEventListenerWildcardByClass('test.*', TestListener::class . '@respondWildcard');
    }
}

uses(PackageLoadsEventListenerWildcardClassCombinedMethodTest::class);

it("registers Wildcard listeners by class with class@method", function () {
    Event::assertListening('test.test', TestListener::class . '@respondWildcard');
})->group('events');
