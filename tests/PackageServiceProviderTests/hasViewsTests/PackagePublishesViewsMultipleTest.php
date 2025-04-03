<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesViewsMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesViewsByPath()
            ->publishesViewsByPath('custom-namespace', '../resources/views_alt');
    }
}

uses(PackagePublishesViewsMultipleTest::class);

it("can publish the views with a custom namespace and path and tag", function () {
    $file = resource_path('views/vendor/custom-namespace/test-alt.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=custom-namespace-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views');

it("can publish the views with a custom namespace and path", function () {
    $file1 = resource_path('views/vendor/package-tools/test.blade.php');
    $file2 = resource_path('views/vendor/custom-namespace/test-alt.blade.php');
    expect($file1)->not->toBeFileOrDirectory();
    expect($file2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file1)->toBeFile();
    expect($file2)->toBeFile();
})->group('views');
