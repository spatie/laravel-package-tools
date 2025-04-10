<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\AssetsTests;

use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Package;

trait PackageHasAssetsLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasAssets();
    }
}

uses(PackageHasAssetsLegacyTest::class);

it('can publish the assets', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-assets')
        ->assertExitCode(0);

    assertFileExists(public_path('vendor/package-tools/dummy.js'));
});
