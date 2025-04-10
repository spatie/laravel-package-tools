<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\_BasicTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Providers\AltLocationServiceProvider;

trait PackageBasePathAltLocationTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');
    }
}

uses(PackageBasePathAltLocationTest::class);

it('will set the base path to the Src dir when the PackageServiceProvider is in an alternate location', function () {
    $provider = new AltLocationServiceProvider(app());
    expect($provider->getPackageBaseDir())->toEndWith(DIRECTORY_SEPARATOR.'TestPackage'.DIRECTORY_SEPARATOR.'Src');
})->group('base', 'legacy');
