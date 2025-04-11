<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\CommandsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\TestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\ThirdTestCommand;

trait PackageHasConsoleCommandsLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasConsoleCommand(commandClassName: TestCommand::class)
            ->hasConsoleCommands([OtherTestCommand::class])
            ->hasConsoleCommands(ThirdTestCommand::class, FourthTestCommand::class);
    }
}

uses(PackageHasConsoleCommandsLegacyTest::class);

it("can register and execute legacy Console Commands loaded by hasConsoleCommand", function () {
    $this
        ->artisan('package-tools:test-command')
        ->assertSuccessful()
        ->expectsOutput('output of test command');

    $this
        ->artisan('package-tools:other-test-command')
        ->assertSuccessful()
        ->expectsOutput('output of other test command');
})->group('commands', 'legacy');
