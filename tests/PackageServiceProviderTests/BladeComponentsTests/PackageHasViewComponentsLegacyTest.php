<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\BladeComponentsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponentTwo;

trait PackageHasViewComponentsLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComponent(prefix: 'abc', viewComponentName: TestComponent::class)
            ->hasViewComponents('abc', TestComponentTwo::class);
    }
}

uses(PackageHasViewComponentsLegacyTest::class);

it("can load multiple blade components by legacy hasViewComponents", function () {
    $content = view('package-tools::component-test-two')->render();

    expect($content)->toStartWith('<div>hello mars</div>');
})->group('blade', 'blade-components', 'legacy');

it("can publish multiple blade components by legacy hasViewComponents", function () {
    $file = app_path('View/Components/vendor/package-tools/TestComponent.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})->group('blade', 'blade-components', 'legacy');
