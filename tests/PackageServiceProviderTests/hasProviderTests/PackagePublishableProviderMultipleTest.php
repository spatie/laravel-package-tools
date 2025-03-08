<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishableProviderMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider('MyPackageServiceProvider')
            ->publishesServiceProvider('../resources/stubs_alt/MyAltPackageServiceProvider');
    }
}

uses(PackagePublishableProviderMultipleTest::class);

it("can publish multiple service providers", function () {
    $providerPath1 = app_path('Providers/MyPackageServiceProvider.php');
    $providerPath2 = app_path('Providers/MyAltPackageServiceProvider.php');
    expect($providerPath1)->not->toBeFileOrDirectory();
    expect($providerPath2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($providerPath1)->toBeFile();
    expect($providerPath2)->toBeFile();
})->group('provider');
