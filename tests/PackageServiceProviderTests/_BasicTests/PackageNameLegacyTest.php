<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\_BasicTests;

use function PHPUnit\Framework\assertTrue;
use Spatie\LaravelPackageTools\Package;

trait PackageNameLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');
    }
}

uses(PackageNameLegacyTest::class);

it('will not blow up when a name is set', function () {
    assertTrue(true);
});
