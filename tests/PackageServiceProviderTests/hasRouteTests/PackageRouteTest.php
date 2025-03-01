<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRouteTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes(['web', 'other']);
    }
}

uses(PackageRouteTest::class);

it("can load the route", function () {
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
})->group('routes');

it("can load multiple route", function () {
    $adminResponse = $this->get('other-route');

    $adminResponse->assertSeeText('other response');
})->group('routes');
