<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackageInertiaAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasInertiaComponents('my_inertia', '../resources/js_alt/Pages');
    }
}

uses(PackageInertiaAltNamespacePathTest::class);

it("can publish the alternate inertia components under an alternate namespace", function () {
    $file = resource_path("js/Pages/MyInertia/dummy_alt.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia');
