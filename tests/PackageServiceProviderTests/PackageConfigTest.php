<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

beforeAll(function () {
    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasConfigFile();
    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_register_the_config_file',function(){
    $this->assertEquals('value', config('package-tools.key'));
});

it('can_publish_the_config_file', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertExitCode(0);

    $this->assertFileExists(config_path('package-tools.php'));
});
