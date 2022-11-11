<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\TestTime\TestTime;


beforeAll(function () {

    TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasRoutes('web', 'other');

    PackageServiceProviderConcreteTestCase::package($package);
});


it('can_load_the_route',function(){
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
});

it('can_load_multiple_route', function () {
    $adminResponse = $this->get('other-route');

    $adminResponse->assertSeeText('other response');
});
