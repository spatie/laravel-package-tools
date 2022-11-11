<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasViews()
        ->sharesDataWithAllViews('sharedItemTest', 'hello_world');

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_share_data_with_all_views',function(){

    $content1 = view('package-tools::shared-data')->render();
    $content2 = view('package-tools::shared-data-2')->render();

    $this->assertStringStartsWith('hello_world', $content1);
    $this->assertStringStartsWith('hello_world', $content2);

});
