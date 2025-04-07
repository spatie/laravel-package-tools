<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\basicTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Providers\AltLocationServiceProvider;

trait ConfigurePackageBasePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');
    }
}

uses(ConfigurePackageBasePathTest::class);

it('will set the base path to the Src dir when the PackageServiceProvider is in an alternate location', function () {
    $provider = new AltLocationServiceProvider(app());
    expect($provider->getPackageBaseDir())->toEndWith(DIRECTORY_SEPARATOR.'TestPackage'.DIRECTORY_SEPARATOR.'Src');
})->group('base', 'legacy');
