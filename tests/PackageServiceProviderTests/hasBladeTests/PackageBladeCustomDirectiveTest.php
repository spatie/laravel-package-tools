<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Spatie\LaravelPackageTools\Package;

trait PackageBladeCustomDirectiveTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeCustomDirective('testdirective', function ($expression) {
                return "<div><?php echo $expression; ?></div>";
            })
        ;
    }
}

uses(PackageBladeCustomDirectiveTest::class);

it("can load and use the blade custom directive", function () {
    $content = view('package-tools::custom-directive-test')->render();

    expect($content)->toStartWith('<div>hello world</div>');
})->group('blade');
