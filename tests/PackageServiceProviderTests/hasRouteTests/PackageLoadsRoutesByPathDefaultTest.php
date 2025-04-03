<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsRoutesByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsRoutesByPath();
    }
}

uses(PackageLoadsRoutesByPathDefaultTest::class);

it("can load multiple routes by default path", function () {
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
    $adminResponse = $this->get('other-route');

    $adminResponse->assertSeeText('other response');
})->group('routes');
