<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsViewsAltPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath(path: '../resources/views_alt');
    }
}

uses(PackageLoadsViewsAltPathTest::class);

it("can load the views with a custom path", function () {
    $content = view('package-tools::test-alt')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views');
