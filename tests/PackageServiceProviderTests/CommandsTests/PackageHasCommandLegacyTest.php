<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\CommandsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\TestCommand;

trait PackageHasCommandLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommand(commandClassName: TestCommand::class);
    }
}

uses(PackageHasCommandLegacyTest::class);

it('can execute a registered commands', function () {
    $this
        ->artisan('package-tools:test-command')
        ->assertExitCode(0);
})->group('commands', 'legacy');
