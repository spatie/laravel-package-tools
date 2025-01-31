<?php

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringStartsWith;
use Spatie\LaravelPackageTools\Package;

trait ConfigurePackageViewsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews();
    }
}

uses(ConfigurePackageViewsTest::class);

it('can load the views', function () {
    $content = view('package-tools::test')->render();

    assertStringStartsWith('This is a blade view', $content);
});

it('can publish the views', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-views')
        ->assertExitCode(0);

    assertFileExists(resource_path('views/vendor/package-tools/test.blade.php'));
});
