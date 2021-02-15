<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestClasses\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\TestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\ThirdTestCommand;

class PackageCommandsTest extends PackageServiceProviderTestCase
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommand(TestCommand::class)
            ->hasCommands([OtherTestCommand::class])
            ->hasCommands(ThirdTestCommand::class, FourthTestCommand::class);
    }

    /** @test */
    public function it_can_execute_a_registered_commands()
    {
        $this
            ->artisan('test-command')
            ->assertExitCode(0);

        $this
            ->artisan('other-test-command')
            ->assertExitCode(0);
    }
}
