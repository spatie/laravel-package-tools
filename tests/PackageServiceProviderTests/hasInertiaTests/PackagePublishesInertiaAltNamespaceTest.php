<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaAltNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath('my-inertia');
    }
}

uses(PackagePublishesInertiaAltNamespaceTest::class);

it("can publish alternate namespace inertia components", function () {
    $file = resource_path("js/Pages/MyInertia/inertia.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia');

it("can publish alternate namespace inertia components under the namespace tag", function () {
    $file = resource_path("js/Pages/MyInertia/inertia.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=my-inertia-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia');
