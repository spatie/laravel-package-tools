<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesAssetsMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesAssetsByPath('myassets', '../resources/dist_alt')
            ->publishesAssetsByPath();
    }
}

uses(PackagePublishesAssetsMultipleTest::class);

it("can publish both default and alternate assets", function () {
    $file1 = public_path('vendor/myassets/dummy_alt.js');
    $file2 = public_path('vendor/package-tools/dummy.js');
    expect($file1)->not->toBeFileOrDirectory();
    expect($file2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertSuccessful();

    expect($file1)->toBeFile();
    expect($file2)->toBeFile();
})->group('assets');
