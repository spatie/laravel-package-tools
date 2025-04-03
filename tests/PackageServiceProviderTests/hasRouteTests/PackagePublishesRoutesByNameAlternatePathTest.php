<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesRoutesByNameAlternatePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesRoutesByName('web_alt')
            ->publishesRoutesByName('other_alt')
            ->setRoutesByNamePath('../routes_alt');
    }
}

uses(PackagePublishesRoutesByNameAlternatePathTest::class);

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
