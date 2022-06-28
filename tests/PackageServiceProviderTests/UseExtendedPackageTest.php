<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\ServiceProviderWithExtendedPackage;

class UseExtendedPackageTest extends PackageServiceProviderTestCase
{

    private Package $package;

    protected function getPackageProviders($app): array
    {
        return [
            ServiceProviderWithExtendedPackage::class,
        ];
    }

    public function configurePackage(Package $package)
    {
        $package->name('bar');
        $this->package = $package;
    }

    /** @test */
    public function it_was_overridden()
    {
        $this->assertSame($this->package->name, 'foo-bar');
        $this->assertSame($this->package->shortName(), 'bar');
    }

}
