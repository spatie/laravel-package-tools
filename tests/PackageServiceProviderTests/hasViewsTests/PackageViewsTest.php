<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasViewsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageViewsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews();
    }
}

uses(PackageViewsTest::class);

it('can load the views', function () {
    $content = view('package-tools::test')->render();

    $this->assertStringStartsWith('This is a blade view', $content);
});

it('can publish the views', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertExitCode(0);

    $this->assertFileExists(resource_path('views/vendor/package-tools/test.blade.php'));
});
