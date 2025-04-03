<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath();
    }
}

uses(PackagePublishesInertiaTest::class);

it("can publish the inertia components", function () {
    $file = resource_path("js/Pages/PackageTools/inertia.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia');
