<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackagePublishesViewsDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesViewsByPath();
    }
}

uses(PackagePublishesViewsDefaultTest::class);

it("can publish default views", function () {
    $file = resource_path('views/vendor/package-tools/test.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views', 'legacy');
