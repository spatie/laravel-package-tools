<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasAssetsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageAssetsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets()
            ->setAssetsPath('/../resources/dist_alt');
    }
}

uses(PackageAssetsAltPathTest::class);

it('can publish the alternate assets', function () {
    $file = public_path('vendor/package-tools/dummy_alt.js');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
