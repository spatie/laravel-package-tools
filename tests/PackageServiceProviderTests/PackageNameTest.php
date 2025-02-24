<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackageNameTest
{
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');
    }
}

uses(PackageNameTest::class);

it('will not blow up when a name is set', function () {
    expect(true)->toBeTrue();
});
