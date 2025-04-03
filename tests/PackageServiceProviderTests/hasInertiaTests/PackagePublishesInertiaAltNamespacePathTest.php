<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath('my-inertia', '../resources/js_alt/Pages');
    }
}

uses(PackagePublishesInertiaAltNamespacePathTest::class);

it("can publish the alternate inertia components under an alternate namespace", function () {
    $file = resource_path("js/Pages/MyInertia/inertia_alt.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia');
