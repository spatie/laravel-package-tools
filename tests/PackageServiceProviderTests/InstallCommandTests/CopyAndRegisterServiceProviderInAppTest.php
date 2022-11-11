<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderConcreteTestCase;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasConfigFile()
        ->publishesServiceProvider('MyPackageServiceProvider')
        ->hasInstallCommand(function (InstallCommand $command) {
            $command->copyAndRegisterServiceProviderInApp();
        });
    PackageServiceProviderConcreteTestCase::package($package);

});

it('can_copy_and_register_the_service_provider_in_the_app',function(){
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    $this->assertStringContainsString(
        "App\Providers\MyPackageServiceProvider::class",
        file_get_contents(base_path('config/app.php'))
    );

    $this->restoreAppConfigFile();
});
