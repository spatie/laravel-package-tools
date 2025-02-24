<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait InstallCopyAndRegisterServiceProviderInAppTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->publishesServiceProvider('MyPackageServiceProvider')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->copyAndRegisterServiceProviderInApp();
            });
    }
}

/*
 * If we leave the published config file in,
 * all subsequent tests will fail
 */
function restoreAppConfigFile(): void
{
    $file = config_path('app.php');
    $newContent = str_replace(
        'App\Providers\MyPackageServiceProvider::class,',
        '',
        file_get_contents($file)
    );

    file_put_contents($file, $newContent);
}

uses(InstallCopyAndRegisterServiceProviderInAppTest::class);

it('can copy and register the service provider in the app', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    if (intval(app()->version()) < 11) {
        expect(base_path('config/app.php'))->toHaveContentsIncluding("App\Providers\MyPackageServiceProvider::class");
    }

    restoreAppConfigFile();
});
