<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageBladeComponentsByClassDuplicatePrefixTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeComponentsByClass('abc', TestComponent::class)
            ->hasBladeComponentsByClass('abc', TestComponent::class);
    }
}

uses(PackageBladeComponentsByClassDuplicatePrefixTest::class);

it("can load the blade components by class when duplicated", function () {
    $content = view('package-tools::component-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade');

it("can publish the blade components by class when duplicated", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('blade');
