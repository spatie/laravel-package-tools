<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Package;

trait PackageBladeComponentsByNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeComponentsByNamespace('abc', 'Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components');
    }
}

uses(PackageBladeComponentsByNamespaceTest::class);

it('can load the blade components by namespace', function () {
    $content = view('package-tools::component-test-namespace')->render();

    expect($content)->toStartWith('<div>hello world</div>');
});
