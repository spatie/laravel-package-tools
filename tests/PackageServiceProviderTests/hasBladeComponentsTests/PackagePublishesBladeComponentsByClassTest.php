<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackagePublishesBladeComponentsByClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            //->hasViews()
            ->publishesBladeComponentsByClass('abc', TestComponent::class);
    }
}

uses(PackagePublishesBladeComponentsByClassTest::class);

it("can publish the blade components by class", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('blade', 'blade-components');
