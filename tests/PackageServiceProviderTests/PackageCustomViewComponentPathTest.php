<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Components\PathTestComponent;

class PackageCustomViewComponentPathTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->setViewComponentPath($package->basePath('../Components'))
            ->hasViewComponent('abc', PathTestComponent::class);
    }

    /** @test */
    public function it_can_load_the_view_components()
    {
        $content = view('package-tools::component-path-test')->render();

        $this->assertStringStartsWith('<div>hello world</div>', $content);
    }

    /** @test */
    public function it_can_publish_the_view_components()
    {
        $this
            ->artisan('vendor:publish --tag=laravel-package-tools-components')
            ->assertExitCode(0);

        $this->assertFileExists(base_path('app/View/Components/vendor/package-tools/PathTestComponent.php'));
    }
}
