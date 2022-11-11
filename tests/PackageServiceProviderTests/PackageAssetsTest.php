<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasAssets();

    PackageServiceProviderConcreteTestCase::package($package);
});


it('can_publish_the_assets',function(){

    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertExitCode(0);

    $this->assertFileExists(public_path('vendor/package-tools/dummy.js'));
});
