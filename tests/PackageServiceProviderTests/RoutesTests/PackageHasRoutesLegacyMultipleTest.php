<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\RouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasRoutesLegacyMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web', 'other');
    }
}

uses(PackageHasRoutesLegacyMultipleTest::class);

it("can load the legacy multiple routes", function () {
    $response = $this->get('my-route');
    $response->assertSeeText('my response');

    $adminResponse = $this->get('other-route');
    $adminResponse->assertSeeText('other response');
})->group('routes', 'legacy');
