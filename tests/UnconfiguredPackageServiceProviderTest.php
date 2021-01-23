<?php


namespace Spatie\LaravelPackageTools\Tests;

use Exception;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Tests\TestClasses\ServiceProvider;

class UnconfiguredPackageServiceProviderTest extends TestCase
{
    /** @test */
    public function it_will_throw_an_exception_if_no_package_name_is_set()
    {
        $this->expectException(InvalidPackage::class);

        (new ServiceProvider(app()))->register();
    }

}
