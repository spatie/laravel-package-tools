<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath('my_inertia', '../resources/js_alt/Pages')
            ->publishesInertiaComponentsByPath();
    }
}

uses(PackagePublishesInertiaMultipleTest::class);

it("can publish both default and alternate inertia components", function () {
    $file1 = resource_path("js/Pages/PackageTools/inertia.js");
    $file2 = resource_path("js/Pages/MyInertia/inertia_alt.js");
    expect($file1)->not->toBeFileOrDirectory();
    expect($file2)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-inertia-components')
        ->assertSuccessful();

    expect($file1)->toBeFile();
    expect($file2)->toBeFile();
})->group('inertia');
