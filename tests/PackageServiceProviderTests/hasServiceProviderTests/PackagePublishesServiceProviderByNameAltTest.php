<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderByNameAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvidersByName('../resources/stubs_alt/MyAltPackageServiceProvider');
    }
}

uses(PackagePublishesServiceProviderByNameAltTest::class);

it("can publish an alternative service provider", function () {
    $providerPath = app_path('Providers/MyAltPackageServiceProvider.php');

    expect($providerPath)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($providerPath)->toBeFile();
})->group('provider');
