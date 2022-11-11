<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestClasses\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\TestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\ThirdTestCommand;

beforeAll(function () {
    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasCommand(TestCommand::class)
        ->hasCommands([OtherTestCommand::class])
        ->hasCommands(ThirdTestCommand::class, FourthTestCommand::class);
    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_execute_a_registered_commands',function(){

    $this
        ->artisan('test-command')
        ->assertExitCode(0);

    $this
        ->artisan('other-test-command')
        ->assertExitCode(0);

});
