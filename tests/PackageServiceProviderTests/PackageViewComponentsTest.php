<?php

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Components\TestComponent;
use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringStartsWith;

trait ConfigurePackageViewComponentsTest {
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComponent('abc', TestComponent::class);
    }
}

uses(ConfigurePackageViewComponentsTest::class);

test('it can load the view components', function () {
    $content = view('package-tools::component-test')->render();

    assertStringStartsWith('<div>hello world</div>', $content);
});

test('it can publish the view components', function () {
    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertExitCode(0);

    assertFileExists(base_path('app/View/Components/vendor/package-tools/TestComponent.php'));
});
