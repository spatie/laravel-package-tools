<?php

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use function PHPUnit\Framework\assertStringContainsString;

trait ConfigureCopyAndRegisterServiceProviderInAppTest {
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
    $newContent = str_replace(
        'App\Providers\MyPackageServiceProvider::class,',
        '',
        file_get_contents(base_path('config/app.php'))
    );

    file_put_contents(base_path('config/app.php'), $newContent);
}

uses(ConfigureCopyAndRegisterServiceProviderInAppTest::class);

it('can copy and register the service provider in the app', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    assertStringContainsString(
        "App\Providers\MyPackageServiceProvider::class",
        file_get_contents(base_path('config/app.php'))
    );

    restoreAppConfigFile();
});
