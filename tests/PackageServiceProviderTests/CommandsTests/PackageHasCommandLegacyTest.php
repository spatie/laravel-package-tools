<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\CommandsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestClasses\TestCommand;

trait PackageHasCommandLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommand(TestCommand::class);
    }
}

uses(PackageHasCommandLegacyTest::class);

it('can execute a registered commands', function () {
    $this
        ->artisan('test-command')
        ->assertExitCode(0);
});
