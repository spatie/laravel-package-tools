<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

class PackageViewComposerTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComposer('*', function ($view) {
                $view->with('sharedItemTest', 'hello world');
            });
    }

    /** @test */
    public function it_can_load_the_view_composer_and_render_shared_data()
    {
        $content = view('package-tools::shared-data')->render();

        $this->assertStringStartsWith('hello world', $content);
    }
}
