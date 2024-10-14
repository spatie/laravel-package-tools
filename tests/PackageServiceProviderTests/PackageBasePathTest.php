<?php

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Providers\ServiceProvider;

trait ConfigurePackageBasePathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');
    }
}

uses(ConfigurePackageBasePathTest::class);

it('will set the base path to the Src dir when the laravel folder organisation is applied', function () {
    $provider = new ServiceProvider(app());
    expect($provider->getPackageBaseDir())->toEndWith( DIRECTORY_SEPARATOR.'TestPackage'.DIRECTORY_SEPARATOR.'Src');
});
