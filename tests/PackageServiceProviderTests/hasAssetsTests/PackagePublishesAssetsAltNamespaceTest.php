<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesAssetsAltNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesAssetsByPath('myassets');
    }
}

uses(PackagePublishesAssetsAltNamespaceTest::class);

it("can publish the alternate assets", function () {
    $file = public_path('vendor/myassets/dummy.js');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('assets');
