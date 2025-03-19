<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageBladeAnonymousComponentsByPathNullTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');

        if (! is_before_laravel_version(App::version(), '9.44.0')) {
            $package
                ->hasViews()
                ->hasBladeAnonymousComponentsByPath(null);
        }
    }
}

uses(PackageBladeAnonymousComponentsByPathNullTest::class);

it("can load the blade components by path", function () {
    $content = view('package-tools::component-test-anonymous-null')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})
    ->group('blade')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '9.44.0'),
        message_before_laravel_version('9.44.0', 'hasAnonymousComponentsByPath')
    );

it("can publish the blade components by path", function () {
    $file = resource_path('views/vendor/package-tools/components/anonymous-component.blade.php');
    expect($file)->not->toBeFileOrDirectory();

    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertSuccessful();

    expect($file)->toBeFile();
})
    ->group('blade')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '9.44.0'),
        message_before_laravel_version('9.44.0', 'hasAnonymousComponentsByPath')
    );
