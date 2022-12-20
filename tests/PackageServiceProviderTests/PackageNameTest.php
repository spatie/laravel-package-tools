<?php

use function PHPUnit\Framework\assertTrue;
use Spatie\LaravelPackageTools\Package;

trait ConfigurePackageNameTest
{
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');
    }
}

uses(ConfigurePackageNameTest::class);

it('will not blow up when a name is set', function () {
    assertTrue(true);
});
