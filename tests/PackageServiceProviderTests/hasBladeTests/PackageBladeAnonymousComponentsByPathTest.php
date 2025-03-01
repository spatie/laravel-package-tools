<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeAnonymousComponentsByPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');

        if (! is_before_laravel_9_44_0(App::version())) {
            $package
                ->hasViews()
                ->hasBladeAnonymousComponentsByPath('abc');
        }
    }
}

uses(PackageBladeAnonymousComponentsByPathTest::class);

it("can load the blade components by path", function () {
    $content = view('package-tools::component-test-anonymous')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})
    ->group('blade')
    ->skip(fn () => is_before_laravel_9_44_0(App::version()), message_before_laravel_9_44_0());

it("can publish the blade components by path", function () {
    $file = resource_path('views/components/vendor/package-tools/anonymous-component.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-anonymous-components')
        ->assertSuccessful();

    expect($file)->toBeFile();
})
    ->group('blade')
    ->skip(fn () => is_before_laravel_9_44_0(App::version()), message_before_laravel_9_44_0());
