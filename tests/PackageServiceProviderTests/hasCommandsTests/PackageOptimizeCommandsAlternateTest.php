<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\ThirdTestCommand;

trait PackageOptimizeCommandsAlternateTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommands(FourthTestCommand::class, ThirdTestCommand::class)
            ->hasOptimizeCommands("my-package:fourth-test-command", "my-package:third-test-command");
    }
}

uses(PackageOptimizeCommandsAlternateTest::class);

it("will throw an exception with hasOptimizeCommands when the Laravel version is before 11.27.1")
    ->group('commands')
    ->skip(fn () => ! is_before_laravel_version(App::version(), '11.27.1'), "hasOptimizeCommands only throws an InvalidPackage exception on Laravel < 11.27.1")
    ->throws(InvalidPackage::class, "hasOptimizeCommands requires functionality first implemented in Laravel v11.27.1 in package laravel-package-tools");

it("can register and execute commands for Optimize", function () {
    $this
        ->artisan('my-package:fourth-test-command')
        ->assertSuccessful()
        ->expectsOutput('output of fourth test command');

    $this
        ->artisan('my-package:third-test-command')
        ->assertSuccessful()
        ->expectsOutput('output of third test command');
})
    ->group('commands')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '11.27.1'),
        message_before_laravel_version('11.27.1', 'hasOptimizeCommands')
    );

it("can register and execute Optimize Commands", function () {
    $this
        ->artisan('optimize')
        ->assertSuccessful()
        ->expectsOutput('output of fourth test command');

    $this
        ->artisan('optimize:clear')
        ->assertSuccessful()
        ->expectsOutput('output of third test command');
})
    ->group('commands')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '11.27.1'),
        message_before_laravel_version('11.27.1', 'hasOptimizeCommands')
    );
