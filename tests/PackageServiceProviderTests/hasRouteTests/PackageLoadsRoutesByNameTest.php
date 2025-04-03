<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsRoutesByNameTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsRoutesByName('web')
            ->loadsRoutesByName('other');
    }
}

uses(PackageLoadsRoutesByNameTest::class);

it("can load multiple individual routes by name", function () {
    $response = $this->get('my-route');
    $response->assertSeeText('my response');

    $adminResponse = $this->get('other-route');
    $adminResponse->assertSeeText('other response');
})->group('routes');
