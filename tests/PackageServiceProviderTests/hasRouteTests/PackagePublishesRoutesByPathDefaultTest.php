<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasRouteTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesRoutesByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesRoutesByPath();
    }
}

uses(PackagePublishesRoutesByPathDefaultTest::class);

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
