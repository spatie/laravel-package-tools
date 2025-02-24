<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasSharedDataTests;

use Spatie\LaravelPackageTools\Package;

trait PackageSharedDataTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->sharesDataWithAllViews('sharedItemTest', 'hello_world');
    }
}

uses(PackageSharedDataTest::class);

it('can share data with all views', function () {
    $content1 = view('package-tools::shared-data')->render();
    $content2 = view('package-tools::shared-data-2')->render();

    $this->assertStringStartsWith('hello_world', $content1);
    $this->assertStringStartsWith('hello_world', $content2);
});
