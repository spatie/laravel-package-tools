<?php

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Package;

trait ConfigurePackageMultipleConfigTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile(['package-tools', 'alternative-config']);
    }
}

uses(ConfigurePackageMultipleConfigTest::class);

it('can register multiple config files', function () {
    assertEquals('value', config('package-tools.key'));

    assertEquals('alternative_value', config('alternative-config.alternative_key'));
});

it('can publish multiple config files', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-config')
        ->assertExitCode(0);

    assertFileExists(config_path('alternative-config.php'));
});
