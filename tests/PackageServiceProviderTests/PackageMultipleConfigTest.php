<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertEquals;

trait ConfigurePackageMultipleConfigTest {
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile(['package-tools', 'alternative-config']);
    }
}

uses(ConfigurePackageMultipleConfigTest::class);

test('it can register multiple config files', function () {
    assertEquals('value', config('package-tools.key'));

    assertEquals('alternative_value', config('alternative-config.alternative_key'));
});
