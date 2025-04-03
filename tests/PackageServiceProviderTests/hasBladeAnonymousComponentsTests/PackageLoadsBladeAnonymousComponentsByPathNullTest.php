<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeAnonymousComponentsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeAnonymousComponentsByPathNullTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');

        if (! is_before_laravel_version(App::version(), '9.44.0')) {
            $package
                ->loadsViewsByPath()
                ->loadsBladeAnonymousComponentsByPath(null);
        }
    }
}

uses(PackageLoadsBladeAnonymousComponentsByPathNullTest::class);

it("can load the blade components by path", function () {
    $content = view('package-tools::component-test-anonymous-null')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})
    ->group('blade', 'blade-anonymous')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '9.44.0'),
        message_before_laravel_version('9.44.0', 'hasAnonymousComponentsByPath')
    );
