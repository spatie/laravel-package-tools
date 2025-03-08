<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByPathAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeComponentsByPath('abc', "Components_alt");
    }
}

uses(PackageBladeComponentsByPathAltTest::class);

it("can load the blade components by alternate path", function () {
    $content = view('package-tools::component-test-namespace')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade');

it("can publish the blade components by alternate path", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('blade');
