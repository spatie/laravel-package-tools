<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsRoutesByNameAlternatePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsRoutesByName('web_alt')
            ->loadsRoutesByName('other_alt')
            ->setRoutesByNamePath('../routes_alt');
    }
}

uses(PackageLoadsRoutesByNameAlternatePathTest::class);

it("can load multiple individual routes by name", function () {
    $response = $this->get('my-route-alt');
    $response->assertSeeText('my response');

    $adminResponse = $this->get('other-route-alt');
    $adminResponse->assertSeeText('other response');
})->group('routes');
