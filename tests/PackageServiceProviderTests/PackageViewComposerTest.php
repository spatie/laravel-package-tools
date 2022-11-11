<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertStringStartsWith;

trait ConfigurePackageViewComposerTest {
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComposer('*', function ($view) {
                $view->with('sharedItemTest', 'hello world');
            });
    }
}

uses(ConfigurePackageViewComposerTest::class);

it('can load the view composer and render shared data', function () {
    $content = view('package-tools::shared-data')->render();

    assertStringStartsWith('hello world', $content);
});
