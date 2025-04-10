<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ConfigTests;

use function PHPUnit\Framework\assertEquals;
use Spatie\LaravelPackageTools\Package;

trait PackageHasConfigFileLegacyMultipleTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile(['package-tools', 'alternative-config']);
    }
}

uses(PackageHasConfigFileLegacyMultipleTest::class);

it('can register multiple config files', function () {
    assertEquals('value', config('package-tools.key'));

    assertEquals('alternative_value', config('alternative-config.alternative_key'));
});
