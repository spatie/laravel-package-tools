<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\AssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasAssetsLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets();
    }
}

uses(PackageHasAssetsLegacyTest::class);

it("can publish the assets", function () {
    $file = public_path('vendor/package-tools/dummy.js');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('assets', 'legacy');
