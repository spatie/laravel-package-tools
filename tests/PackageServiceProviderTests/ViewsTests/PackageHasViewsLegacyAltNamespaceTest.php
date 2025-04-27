<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageHasViewsLegacyAltNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews(namespace: 'custom-namespace');
    }
}

uses(PackageHasViewsLegacyAltNamespaceTest::class);

it("can load the views with a custom namespace", function () {
    $content = view('custom-namespace::test')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views', 'legacy');

it("can publish the views with a custom namespace and tag", function () {
    $file = resource_path('views/vendor/custom-namespace/test.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=custom-namespace-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('views', 'legacy');
