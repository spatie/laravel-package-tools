<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

trait InstallStarRepoTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->askToStarRepoOnGitHub('spatie/spatie.be');
            });
    }
}

uses(InstallStarRepoTest::class);

it('can propose to star the repo', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful()
        ->expectsConfirmation('Would you like to star our repo on GitHub?');
});
