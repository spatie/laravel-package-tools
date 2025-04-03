<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderByNameDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvidersByName();
    }
}

uses(PackagePublishesServiceProviderByNameDefaultTest::class);

it("can publish a service provider", function () {
    $providerPath = app_path('Providers/PackageToolsServiceProvider.php');

    expect($providerPath)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($providerPath)->toBeFile();
})->group('provider');
