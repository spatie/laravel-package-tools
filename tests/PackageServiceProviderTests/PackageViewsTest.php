<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageViewsTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews();
    }

    /** @test */
    public function it_can_load_the_views()
    {
        $content = view('laravel-package-tools::test')->render();

        $this->assertStringStartsWith('This is a blade view', $content);
    }

    /** @test */
    public function it_can_publish_the_views()
    {
        $this
            ->artisan('vendor:publish --tag=laravel-package-tools-views')
            ->assertExitCode(0);

        $this->assertFileExists(base_path('resources/views/vendor/laravel-package-tools/test.blade.php'));
    }
}
