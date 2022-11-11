<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasViews()
        ->hasViewComposer('*', function ($view) {
            $view->with('sharedItemTest', 'hello world');
        });

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_load_the_view_composer_and_render_shared_data', function () {

    $content = view('package-tools::shared-data')->render();

    $this->assertStringStartsWith('hello world', $content);
});
