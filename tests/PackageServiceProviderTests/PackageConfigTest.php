<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;

trait ConfigurePackageConfigTest {
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile();
    }
}

uses(ConfigurePackageConfigTest::class);

it('can register the config file', function () {
    assertEquals('value', config('package-tools.key'));
});

it('can publish the config file', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertExitCode(0);

    assertFileExists(config_path('package-tools.php'));
});
