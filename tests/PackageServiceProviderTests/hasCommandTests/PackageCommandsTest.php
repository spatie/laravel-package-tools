<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands\TestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands\ThirdTestCommand;

trait PackageCommandsTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommand(TestCommand::class)
            ->hasCommands([OtherTestCommand::class])
            ->hasCommands(ThirdTestCommand::class, FourthTestCommand::class);
    }
}

uses(PackageCommandsTest::class);

it('can execute registered commands', function () {
    $this
        ->artisan('test-command')
        ->assertSuccessful();

    $this
        ->artisan('other-test-command')
        ->assertSuccessful();
});
