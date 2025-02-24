<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;

trait PackageEnvironmentTest
{
    public function configurePackage(Package $package)
    {
        $package->name('dummy');
    }
}

uses(PackageEnvironmentTest::class);

test('confirm environment is set to workbench', function () {
    expect(config('app.env'))->toBe('workbench');
});
