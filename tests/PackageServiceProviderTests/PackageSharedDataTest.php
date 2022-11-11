<?php

use function PHPUnit\Framework\assertStringStartsWith;
use Spatie\LaravelPackageTools\Package;

trait ConfigurePackageSharedDataTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->sharesDataWithAllViews('sharedItemTest', 'hello_world');
    }
}

uses(ConfigurePackageSharedDataTest::class);

it('can share data with all views', function () {
    $content1 = view('package-tools::shared-data')->render();
    $content2 = view('package-tools::shared-data-2')->render();

    assertStringStartsWith('hello_world', $content1);
    assertStringStartsWith('hello_world', $content2);
});
