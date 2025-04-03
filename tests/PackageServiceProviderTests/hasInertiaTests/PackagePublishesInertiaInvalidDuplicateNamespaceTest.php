<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasInertiaTests;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesInertiaInvalidDuplicateNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesInertiaComponentsByPath()
            ->publishesInertiaComponentsByPath(path: '../resources/js_alt/Pages');
    }
}

uses(PackagePublishesInertiaInvalidDuplicateNamespaceTest::class);

it("will throw an exception when the same namespace is used twice")
        ->group('inertia')
        ->throws(InvalidPackage::class, "publishesInertiaComponentsByPath cannot use namespace 'package-tools' more than once in package laravel-package-tools");
