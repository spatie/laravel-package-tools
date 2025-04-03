<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsRoutesByPathAlternateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsRoutesByPath('../routes_alt');
    }
}

uses(PackageLoadsRoutesByPathAlternateTest::class);

it("can load multiple routes by alternate path", function () {
    $response = $this->get('my-route-alt');

    $response->assertSeeText('my response');
    $adminResponse = $this->get('other-route-alt');

    $adminResponse->assertSeeText('other response');
})->group('routes');
