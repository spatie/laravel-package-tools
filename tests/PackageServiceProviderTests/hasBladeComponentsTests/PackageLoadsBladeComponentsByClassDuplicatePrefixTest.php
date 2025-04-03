<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageLoadsBladeComponentsByClassDuplicatePrefixTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeComponentsByClass('abc', TestComponent::class)
            ->loadsBladeComponentsByClass('abc', TestComponent::class);
    }
}

uses(PackageLoadsBladeComponentsByClassDuplicatePrefixTest::class);

it("loads the blade components by class when duplicated", function () {
    $content = view('package-tools::component-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade', 'blade-components');
