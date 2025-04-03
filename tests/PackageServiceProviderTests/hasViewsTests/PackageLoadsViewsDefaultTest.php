<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsViewsDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath();
    }
}

uses(PackageLoadsViewsDefaultTest::class);

it("can load default views", function () {
    $content = view('package-tools::test')->render();

    expect($content)->toStartWith('This is a blade view');
})->group('views', 'legacy');
