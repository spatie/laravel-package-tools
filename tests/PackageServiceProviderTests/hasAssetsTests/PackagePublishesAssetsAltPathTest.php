<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesAssetsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesAssetsByPath(path: '../resources/dist_alt');
    }
}

uses(PackagePublishesAssetsAltPathTest::class);

it("can publish the alternate assets", function () {
    $file = public_path('vendor/package-tools/dummy_alt.js');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('assets');
