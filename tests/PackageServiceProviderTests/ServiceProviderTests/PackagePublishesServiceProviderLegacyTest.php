<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ServiceProviderTests;

use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Package;

trait PackagePublishesServiceProviderLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider('MyPackageServiceProvider');
    }
}

uses(PackagePublishesServiceProviderLegacyTest::class);

it('can publish a service provider', function () {
    $providerPath = app_path('Providers/MyPackageServiceProvider.php');

    assertFileDoesNotExist($providerPath);

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    assertFileExists($providerPath);
});
