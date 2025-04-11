<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\RouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasRoutesLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoute(routeFileName: 'web');
    }
}

uses(PackageHasRoutesLegacyTest::class);

it("can load the legacy route", function () {
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
})->group('routes', 'legacy');
