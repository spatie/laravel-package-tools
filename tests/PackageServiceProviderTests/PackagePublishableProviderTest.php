<?php

use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertFileDoesNotExist;
use function PHPUnit\Framework\assertFileExists;

trait ConfigurePackagePublishableProviderTest {
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->publishesServiceProvider('MyPackageServiceProvider');
    }
}

uses(ConfigurePackagePublishableProviderTest::class);

test('it can publish a service provider', function () {
    $providerPath = app_path('Providers/MyPackageServiceProvider.php');

    assertFileDoesNotExist($providerPath);

    $this
        ->artisan('vendor:publish --tag=package-tools-provider')
        ->assertSuccessful();

    assertFileExists($providerPath);
});
