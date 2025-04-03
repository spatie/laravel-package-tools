<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeComponentsByPath('abc');
    }
}

uses(PackageLoadsBladeComponentsByPathTest::class);

it("can load the blade components by path", function () {
    $content = view('package-tools::component-test-namespace')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade');

it("doesn't publish the blade components by path when only loaded", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-components')
        ->assertSuccessful();

    expect($file)->not->toBeFileOrDirectory();
})->group('blade', 'blade-components');
