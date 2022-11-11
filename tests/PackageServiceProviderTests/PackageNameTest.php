<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertTrue;

trait ConfigurePackageNameTest {
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');
    }
}

uses(ConfigurePackageNameTest::class);

it('will not blow up when a name is set', function () {
    assertTrue(true);
});
