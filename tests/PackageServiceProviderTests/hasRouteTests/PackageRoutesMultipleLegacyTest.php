<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRoutesMultipleLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web', 'other');
    }
}

uses(PackageRoutesMultipleLegacyTest::class);

it("can load the legacy multiple routes", function () {
    $response = $this->get('my-route');
    $response->assertSeeText('my response');

    $adminResponse = $this->get('other-route');
    $adminResponse->assertSeeText('other response');
})->group('routes', 'legacy');
