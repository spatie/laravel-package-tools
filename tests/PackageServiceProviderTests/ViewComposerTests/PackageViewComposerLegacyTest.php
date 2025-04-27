<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\ViewComposerTests;

use Spatie\LaravelPackageTools\Package;

trait PackageViewComposerLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComposer(view: '*', viewComposer: function ($view) {
                $view->with('sharedItemTest', 'hello world');
            });
    }
}

uses(PackageViewComposerLegacyTest::class);

it("can load the view composer and render shared data", function () {
    $content = view('package-tools::shared-data')->render();

    expect($content)->toStartWith('hello world');
})->group('viewcomposer', 'legacy');
