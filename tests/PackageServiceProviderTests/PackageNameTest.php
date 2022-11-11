<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {

    $package = new Package();
    $package->name('laravel-package-tools');

    PackageServiceProviderConcreteTestCase::package($package);
});

it('will_not_blow_up_when_a_name_is_set',function(){
    $this->assertTrue(true);
});
