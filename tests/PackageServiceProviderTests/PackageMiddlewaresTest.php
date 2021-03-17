<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Illuminate\Http\Response;
use Illuminate\Routing\Router;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Http\Middleware\PeopleWontStopMeButMiddlewareWill;

class PackageMiddlewaresTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasMiddlewares([
                'gogogo' => PeopleWontStopMeButMiddlewareWill::class,
            ]);
    }

    /** @test */
    public function it_can_register_package_middlewares()
    {
        $router = $this->app->make(Router::class);

        $router->get('/welcome-to-my-precious-hidden-gem')
            ->middleware('laravel-package-tools.gogogo');

        $this->get('/welcome-to-my-precious-hidden-gem')
            ->assertStatus(Response::HTTP_EXPECTATION_FAILED);

        $router->group(['middleware' => 'laravel-package-tools.gogogo'], function() use ($router) {
            $router->get('/lets-try-again');
        });

        $this->get('/lets-try-again')
            ->assertStatus(Response::HTTP_EXPECTATION_FAILED);
    }
}
