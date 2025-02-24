<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageViewsWithCustomNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews('custom-namespace');
    }
}

uses(PackageViewsWithCustomNamespaceTest::class);

it('can load the views with a custom namespace', function () {
    $content = view('custom-namespace::test')->render();

    expect($content)->toStartWith('This is a blade view');
});

it('can publish the views with a custom namespace', function () {
    $file = resource_path('views/vendor/custom-namespace/test.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=custom-namespace-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
