<?php

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringStartsWith;
use Spatie\LaravelPackageTools\Package;

trait ConfigurePackageViewsWithCustomNamespaceTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews('custom-namespace');
    }
}

uses(ConfigurePackageViewsWithCustomNamespaceTest::class);

it('can load the views with a custom namespace', function () {
    $content = view('custom-namespace::test')->render();

    assertStringStartsWith('This is a blade view', $content);
});

it('can publish the views with a custom namespace', function () {
    $this
        ->artisan('vendor:publish --tag=custom-namespace-views')
        ->assertExitCode(0);

    assertFileExists(resource_path('views/vendor/custom-namespace/test.blade.php'));
});
