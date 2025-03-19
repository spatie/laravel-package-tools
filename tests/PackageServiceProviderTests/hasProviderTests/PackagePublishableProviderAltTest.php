<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishableProviderAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider('../resources/stubs_alt/MyAltPackageServiceProvider');
    }
}

uses(PackagePublishableProviderAltTest::class);

it("can publish an alternative service provider", function () {
    $providerPath = app_path('Providers/MyAltPackageServiceProvider.php');

    expect($providerPath)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($providerPath)->toBeFile();
})->group('provider');
