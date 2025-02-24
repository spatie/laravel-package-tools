<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageBladeComponentsByClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeComponentsByClass('abc', TestComponent::class);
    }
}

uses(PackageBladeComponentsByClassTest::class);

it('can load the blade components by class', function () {
    $content = view('package-tools::component-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
});

it('can publish the blade components by class', function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
