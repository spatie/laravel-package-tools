<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRouteByNameTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutesByName('web')
            ->hasRoutesByName('other');
    }
}

uses(PackageRouteByNameTest::class);

it("can load multiple individual routes by name", function () {
    $response = $this->get('my-route');
    $response->assertSeeText('my response');

    $adminResponse = $this->get('other-route');
    $adminResponse->assertSeeText('other response');
})->group('routes');

it("publishes multiple route files", function () {
    $file1 = base_path('routes/web.php');
    $file2 = base_path('routes/other.php');
    expect($file1)->not->toBeFileOrDirectory();
    expect($file2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-routes')
        ->assertSuccessful();

    expect($file1)->toBeFile();
    expect($file2)->toBeFile();
})->group('routes');
