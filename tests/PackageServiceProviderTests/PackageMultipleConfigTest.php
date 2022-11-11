<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasConfigFile(['package-tools', 'alternative-config']);

    PackageServiceProviderConcreteTestCase::package($package);
});


it('can_register_multiple_config_files',function(){
    $this->assertEquals('value', config('package-tools.key'));

    $this->assertEquals('alternative_value', config('alternative-config.alternative_key'));
});
