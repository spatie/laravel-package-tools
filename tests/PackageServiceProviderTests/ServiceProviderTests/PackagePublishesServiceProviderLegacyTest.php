<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider(providerName: 'MyPackageServiceProvider');
    }
}

uses(PackagePublishesServiceProviderLegacyTest::class);

it("can publish a service provider", function () {
    $providerPath = app_path('Providers/MyPackageServiceProvider.php');

    expect($providerPath)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($providerPath)->toBeFile();
})->group('provider', 'legacy');
