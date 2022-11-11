<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;


beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasViews('custom-namespace');

   PackageServiceProviderConcreteTestCase::package($package);
});

it('can load views from a custom namespace', function () {

    $content = view('custom-namespace::test')->render();

    expect($content)->toStartWith('This is a blade view');
});

it('can_publish_the_views_with_a_custom_namespace',function(){

    $this
            ->artisan('vendor:publish --tag=custom-namespace-views')
            ->assertExitCode(0);

        $this->assertFileExists(base_path('resources/views/vendor/custom-namespace/test.blade.php'));
});
