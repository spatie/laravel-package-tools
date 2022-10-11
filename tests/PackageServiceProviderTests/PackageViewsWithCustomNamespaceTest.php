<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageViewsWithCustomNamespaceTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews('custom-namespace');
    }

    /** @test */
    public function it_can_load_the_views_with_a_custom_namespace()
    {
        $content = view('custom-namespace::test')->render();

        $this->assertStringStartsWith('This is a blade view', $content);
    }

    /** @test */
    public function it_can_publish_the_views_with_a_custom_namespace()
    {
        $this
            ->artisan('vendor:publish --tag=custom-namespace-views')
            ->assertExitCode(0);

        $this->assertFileExists(base_path('resources/views/vendor/custom-namespace/test.blade.php'));
    }
}
