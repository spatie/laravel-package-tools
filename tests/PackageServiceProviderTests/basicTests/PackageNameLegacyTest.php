<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\basicTests;

use Spatie\LaravelPackageTools\Package;

trait PackageNameLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');
    }
}

uses(PackageNameLegacyTest::class);

it("will not blow up when a name is set", function () {
    expect(true)->toBeTrue();
})->group('base', 'legacy');
