<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsViewsAltNamespacePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath('custom-namespace', '../resources/views_alt');
    }
}

uses(PackageLoadsViewsAltNamespacePathTest::class);

it("can load the views with a custom namespace", function () {
    $content = view('custom-namespace::test-alt')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views');
