<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderByPathDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvidersByPath();
    }
}

uses(PackagePublishesServiceProviderByPathDefaultTest::class);

it("can publish service providers by Path", function () {
    $files = [
        app_path('Providers/PackageToolsServiceProvider.php'),
        app_path('Providers/MyPackageServiceProvider.php'),
    ];

    expect($files)->each->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    expect($files)->each->toBeFile();
})->group('provider');
