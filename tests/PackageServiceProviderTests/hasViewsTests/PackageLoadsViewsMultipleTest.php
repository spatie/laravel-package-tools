<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsViewsMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsViewsByPath('custom-namespace', '../resources/views_alt');
    }
}

uses(PackageLoadsViewsMultipleTest::class);

it("can load the views with a custom namespace", function () {
    $content = view('package-tools::test')->render();

    expect($content)->toStartWith('This is a blade view');
    $content = view('custom-namespace::test-alt')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views');
