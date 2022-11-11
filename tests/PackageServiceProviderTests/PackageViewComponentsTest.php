<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Components\TestComponent;
beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasViews()
        ->hasViewComponent('abc', TestComponent::class);

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_load_the_view_component', function () {

    $content = view('package-tools::component-test')->render();

    $this->assertStringStartsWith('<div>hello world</div>', $content);
});

it('can_publish_the_view_component', function () {

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertExitCode(0);

    $this->assertFileExists(base_path('app/View/Components/vendor/package-tools/TestComponent.php'));
});
