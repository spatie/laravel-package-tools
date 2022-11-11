<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasViews();

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can load the views', function () {

    $content = view('package-tools::test')->render();

    expect($content)->toStartWith('This is a blade view');
});

it('can publish the views', function () {

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertExitCode(0);

    $this->assertFileExists(base_path('resources/views/vendor/package-tools/test.blade.php'));
});
