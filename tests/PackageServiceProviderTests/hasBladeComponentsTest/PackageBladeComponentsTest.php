<?php

use function PHPUnit\Framework\assertFileExists;
use function PHPUnit\Framework\assertStringStartsWith;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait ConfigurePackageViewComponentsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasViewComponent('abc', TestComponent::class);
    }
}

uses(ConfigurePackageViewComponentsTest::class);

it('can load the view components', function () {
    $content = view('package-tools::component-test')->render();

    assertStringStartsWith('<div>hello world</div>', $content);
});

it('can publish the view components', function () {
    $this
        ->artisan('vendor:publish --tag=laravel-package-tools-components')
        ->assertExitCode(0);

    assertFileExists(app_path('View/Components/vendor/package-tools/TestComponent.php'));
});
