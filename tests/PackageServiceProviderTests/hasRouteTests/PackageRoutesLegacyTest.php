<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRoutesLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoute(['web', 'other']);
    }
}

uses(PackageRoutesLegacyTest::class);

it("can load the legacy route", function () {
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
})->group('routes', 'legacy');

it("can load multiple legacy routes", function () {
    $adminResponse = $this->get('other-route');

    $adminResponse->assertSeeText('other response');
})->group('routes', 'legacy');
