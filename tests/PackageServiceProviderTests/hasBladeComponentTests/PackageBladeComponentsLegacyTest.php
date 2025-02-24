<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageBladeComponentsLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComponent('abc', TestComponent::class);
    }
}

uses(PackageBladeComponentsLegacyTest::class);

it('can load the legacy blade components', function () {
    $content = view('package-tools::component-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
});

it('can publish the legacy blade components', function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
