<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringStartsWith;

trait ConfigurePackageViewsWithCustomNamespaceTest {
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews('custom-namespace');
    }
}

uses(ConfigurePackageViewsWithCustomNamespaceTest::class);

test('it can load the views with a custom namespace', function () {
    $content = view('custom-namespace::test')->render();

    assertStringStartsWith('This is a blade view', $content);
});

test('it can publish the views with a custom namespace', function () {
    $this
        ->artisan('vendor:publish --tag=custom-namespace-views')
        ->assertExitCode(0);

    assertFileExists(base_path('resources/views/vendor/custom-namespace/test.blade.php'));
});
