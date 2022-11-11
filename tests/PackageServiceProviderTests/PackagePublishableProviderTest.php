<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->publishesServiceProvider('MyPackageServiceProvider');

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_publish_a_service_provider',function() {

    $providerPath = app_path('Providers/MyPackageServiceProvider.php');

    $this->assertFileDoesNotExist($providerPath);

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    $this->assertFileExists($providerPath);
});
