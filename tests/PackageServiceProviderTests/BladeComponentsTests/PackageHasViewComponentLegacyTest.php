<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\BladeComponentsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageHasViewComponentLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComponent(prefix: 'abc', viewComponentName: TestComponent::class);
    }
}

uses(PackageHasViewComponentLegacyTest::class);

it("can load blade components using legacy hasViewComponent", function () {
    $content = view('package-tools::component-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade', 'blade-components', 'legacy');

it("can publish blade components by legacy hasViewComponent", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('blade', 'blade-components', 'legacy');
