<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Middleware\TestMiddleware;
use Spatie\TestTime\TestTime;

class PackageMiddlewareGroupTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web', 'api')
            ->hasMiddleware(TestMiddleware::class, 'api');
    }

    /** @test */
    public function it_registers_group_middleware()
    {
        $response = $this->get('api-route');

        $response->assertSeeText('test-middleware-content');

        $response = $this->get('my-route');

        $response->assertDontSeeText('test-middleware-content');
    }
}
