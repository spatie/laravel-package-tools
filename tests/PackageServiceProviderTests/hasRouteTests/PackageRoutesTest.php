<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRoutesTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web', 'other');
    }
}

uses(PackageRoutesTest::class);

it('can load the route', function () {
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
});

it('can load multiple route', function () {
    $adminResponse = $this->get('other-route');

    $adminResponse->assertSeeText('other response');
});
