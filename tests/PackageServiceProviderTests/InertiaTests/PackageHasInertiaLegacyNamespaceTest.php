<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasInertiaLegacyNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasInertiaComponents('my-inertia');
    }
}

uses(PackageHasInertiaLegacyNamespaceTest::class);

it("can publish the default inertia components with alternate namespace using legacy hasInertiaComponents", function () {
    $file = resource_path("js/Pages/MyInertia/inertia.js");
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=my-inertia-inertia-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('inertia', 'legacy');
