<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;

beforeEach(function () {
    $this->stringFromEnd = '';
});

trait InstallEndWithTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->endWith(function (InstallCommand $installCommand) {
                    $this->stringFromEnd = "set by {$installCommand->getName()}";
                });
            });
    }
}

uses(InstallEndWithTest::class);

it('can execute the end with', function () {
    $this
        ->artisan('package-tools:install')
        ->assertSuccessful();

    expect($this->stringFromEnd)->toBe('set by package-tools:install');
});
