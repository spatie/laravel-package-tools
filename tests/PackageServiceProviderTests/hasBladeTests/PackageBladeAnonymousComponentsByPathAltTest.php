<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageBladeAnonymousComponentsByPathAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeAnonymousComponentsByPath('abc', "../resources/views_alt/components");
    }
}

uses(PackageBladeAnonymousComponentsByPathAltTest::class);

it("can load the blade anonymous components by alternate path", function () {
    $content = view('package-tools::component-test-anonymous')->render();

    expect($content)->toStartWith('<div>hello world</div>');
});

it("can publish the blade anonymous components by alternate path", function () {
    $file = resource_path('views/components/vendor/package-tools/anonymous-component.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-anonymous-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
});
