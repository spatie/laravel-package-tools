<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestCase;
use Spatie\LaravelPackageTools\Tests\TestClasses\ServiceProvider;

class PackageNameTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');
    }

    /** @test */
    public function it_will_not_blow_up_when_a_name_is_set()
    {
        $this->assertTrue(true);
    }
}
