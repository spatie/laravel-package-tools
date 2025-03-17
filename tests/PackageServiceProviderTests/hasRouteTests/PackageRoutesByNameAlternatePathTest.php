<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRoutesByNameAlternatePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutesByName('web_alt')
            ->hasRoutesByName('other_alt')
            ->setRoutesByNamePath('../routes_alt');
    }
}

uses(PackageRoutesByNameAlternatePathTest::class);

it("can load multiple individual routes by name", function () {
    $response = $this->get('my-route-alt');
    $response->assertSeeText('my response');

    $adminResponse = $this->get('other-route-alt');
    $adminResponse->assertSeeText('other response');
})->group('routes');

it("publishes multiple route files", function () {
    $file1 = base_path('routes/web_alt.php');
    $file2 = base_path('routes/other_alt.php');
    expect($file1)->not->toBeFileOrDirectory();
    expect($file2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-routes')
        ->assertSuccessful();

    expect($file1)->toBeFile();
    expect($file2)->toBeFile();
})->group('routes');
