<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageAssetsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets();
    }
}

uses(PackageAssetsTest::class);

it('can publish the assets', function () {
    $file = public_path('vendor/package-tools/dummy.js');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
