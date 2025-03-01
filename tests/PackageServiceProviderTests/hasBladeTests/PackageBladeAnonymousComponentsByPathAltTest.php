<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeComponentTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

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
})
    ->group('blade')
    ->skip(fn () => version_compare(App::version(), '9.44.0') < 0, 'Anonymous components not available until Laravel v9.44.0');

it("can publish the blade anonymous components by alternate path", function () {
    $file = resource_path('views/components/vendor/package-tools/anonymous-component.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-anonymous-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})
    ->group('blade')
    ->skip(fn () => version_compare(App::version(), '9.44.0') < 0, 'Anonymous components not available until Laravel v9.44.0');
