<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageViewsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews(path: '../resources/views_alt');
    }
}

uses(PackageViewsAltPathTest::class);

it("can load the views with a custom path", function () {
    $content = view('package-tools::test-alt')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views');

it("can publish the views with a custom path", function () {
    $file = resource_path('views/vendor/package-tools/test-alt.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views');
