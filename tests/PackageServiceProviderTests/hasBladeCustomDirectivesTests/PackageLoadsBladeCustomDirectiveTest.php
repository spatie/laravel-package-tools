<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeCustomDirectivesTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeCustomDirectiveTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeCustomDirective('testdirective', function ($expression) {
                return "<div><?php echo $expression; ?></div>";
            })
        ;
    }
}

uses(PackageLoadsBladeCustomDirectiveTest::class);

it("can load and use the blade custom directive", function () {
    $content = view('package-tools::custom-directive-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade', 'blade-directives');
