<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRouteByPathAlternateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutesByPath('../routes_alt');
    }
}

uses(PackageRouteByPathAlternateTest::class);

it("can load multiple routes by alternate path", function () {
    $response = $this->get('my-route-alt');

    $response->assertSeeText('my response');
    $adminResponse = $this->get('other-route-alt');

    $adminResponse->assertSeeText('other response');
})->group('routes');

it("publishes multiple route files by alternate path", function () {
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
