<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasSharedDataTests;

use Spatie\LaravelPackageTools\Package;

trait PackageSharedDataLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->sharesDataWithAllViews(name: 'sharedItemTest', value: 'hello_world');
    }
}

uses(PackageSharedDataLegacyTest::class);

it("can share data with all views", function () {
    $content1 = view('package-tools::shared-data')->render();
    $content2 = view('package-tools::shared-data-2')->render();

    expect($content1)->toStartWith('hello_world');
    expect($content2)->toStartWith('hello_world');
})->group('shareddata', 'legacy');
