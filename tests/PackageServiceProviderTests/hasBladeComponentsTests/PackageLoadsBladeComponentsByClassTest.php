<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageLoadsBladeComponentsByClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeComponentsByClass('abc', TestComponent::class);
    }
}

uses(PackageLoadsBladeComponentsByClassTest::class);

it("can load the blade components by class", function () {
    $content = view('package-tools::component-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade', 'blade-components');

it("doesn't publish the blade components by class when only loaded", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-components')
        ->assertSuccessful();

    expect($file)->not->toBeFileOrDirectory();
})->group('blade', 'blade-components');
