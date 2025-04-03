<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesBladeComponentsByPathAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            //->hasViews()
            ->publishesBladeComponentsByPath('abc', "Components_alt");
    }
}

uses(PackagePublishesBladeComponentsByPathAltTest::class);

it("can publish the blade components by alternate path", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('blade', 'blade-components');
