<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageSharedDataTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->sharesDataWithAllViews('sharedItemTest', 'hello_world');
    }

    /** @test */
    public function it_can_share_data_with_all_views()
    {
        $content1 = view('package-tools::shared-data')->render();
        $content2 = view('package-tools::shared-data-2')->render();

        $this->assertStringStartsWith('hello_world', $content1);
        $this->assertStringStartsWith('hello_world', $content2);
    }
}
