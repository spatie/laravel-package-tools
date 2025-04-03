<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeComponentsByNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeComponentsByNamespace('abc', 'Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components');
    }
}

uses(PackageLoadsBladeComponentsByNamespaceTest::class);

it("can load the blade components by namespace", function () {
    $content = view('package-tools::component-test-namespace')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade', 'blade-components');
