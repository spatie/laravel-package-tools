<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesViewsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesViewsByPath(path: '../resources/views_alt');
    }
}

uses(PackagePublishesViewsAltPathTest::class);

it("can publish the views with a custom path", function () {
    $file = resource_path('views/vendor/package-tools/test-alt.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views');
