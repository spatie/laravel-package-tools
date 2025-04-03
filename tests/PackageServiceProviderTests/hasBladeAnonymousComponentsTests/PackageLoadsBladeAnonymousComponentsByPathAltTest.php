<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeAnonymousComponentsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeAnonymousComponentsByPathAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools');

        if (! is_before_laravel_version(App::version(), '9.44.0')) {
            $package
                ->loadsViewsByPath(path: '../resources/views_alt')
                ->loadsBladeAnonymousComponentsByPath('abc', '../resources/views_alt/components');
        }
    }
}

uses(PackageLoadsBladeAnonymousComponentsByPathAltTest::class);

it("can load the blade anonymous components by alternate path", function () {
    $content = view('package-tools::component-test-anonymous')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})
    ->group('blade', 'blade-anonymous')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '9.44.0'),
        message_before_laravel_version('9.44.0', 'hasAnonymousComponentsByPath')
    );
