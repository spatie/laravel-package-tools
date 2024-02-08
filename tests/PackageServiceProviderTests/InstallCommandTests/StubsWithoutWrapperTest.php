<?php

use function PHPUnit\Framework\assertFileExists;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use function Spatie\PestPluginTestTime\testTime;

trait ConfigureStubsWithoutPackageNameWrapperFileTest
{
    public function configurePackage(Package $package)
    {
        testTime()->freeze('2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasStubs(false)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishStubs();
            });
    }
}

uses(ConfigureStubsWithoutPackageNameWrapperFileTest::class);

it('can install the stub files without package name wrapper', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertFileExists(base_path('stubs/dummy.stub'));
});
