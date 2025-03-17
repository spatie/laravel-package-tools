<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackageRoutesByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutesByPath();
    }
}

uses(PackageRoutesByPathDefaultTest::class);

it("can load multiple routes by default path", function () {
    $response = $this->get('my-route');

    $response->assertSeeText('my response');
    $adminResponse = $this->get('other-route');

    $adminResponse->assertSeeText('other response');
})->group('routes');

it("publishes multiple route files by default path", function () {
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
