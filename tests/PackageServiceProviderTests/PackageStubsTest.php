<?php

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Package;

trait ConfigurePackageStubsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile();
    }
}

uses(ConfigurePackageStubsTest::class);

it('can publish the stub files', function () {
    $this
        ->artisan('vendor:publish --tag=package-tools-stubs')
        ->assertExitCode(0);

    assertFileExists(base_path('stubs/package-tools/dummy.stub'));
});
