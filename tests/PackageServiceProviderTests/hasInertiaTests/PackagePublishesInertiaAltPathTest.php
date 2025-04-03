<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath(path: '../resources/js_alt/Pages');
    }
}

uses(PackagePublishesInertiaAltPathTest::class);

it("can publish the alternate inertia components", function () {
    $file = resource_path("js/Pages/PackageTools/inertia_alt.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia');
