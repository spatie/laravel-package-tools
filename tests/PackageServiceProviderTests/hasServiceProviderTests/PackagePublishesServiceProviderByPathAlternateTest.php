<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderByPathAlternateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvidersByPath('../resources/stubs_alt');
    }
}

uses(PackagePublishesServiceProviderByPathAlternateTest::class);

it("can publish service providers by Path", function () {
    $file = app_path('Providers/MyAltPackageServiceProvider.php');

    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('provider');
