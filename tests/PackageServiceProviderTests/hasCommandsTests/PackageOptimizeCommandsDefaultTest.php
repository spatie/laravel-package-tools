<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Illuminate\Support\Facades\App;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\OptimizeCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\OptimizeClearCommand;

trait PackageOptimizeCommandsDefaultTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommands(OptimizeCommand::class, OptimizeClearCommand::class)
            ->hasOptimizeCommands();
    }
}

uses(PackageOptimizeCommandsDefaultTest::class);

it("will throw an exception with hasOptimizeCommands when the Laravel version is before 11.27.1")
    ->group('commands')
    ->skip(fn () => ! is_before_laravel_version(App::version(), '11.27.1'), "hasOptimizeCommands only throws an InvalidPackage exception on Laravel < 11.27.1")
    ->throws(InvalidPackage::class, "hasOptimizeCommands requires functionality first implemented in Laravel v11.27.1 in package laravel-package-tools");

it("can register and execute commands for Optimize", function () {
    $this
        ->artisan('package-tools:optimize')
        ->assertSuccessful()
        ->expectsOutput('optimize package-tools');

    $this
        ->artisan('package-tools:clear-optimizations')
        ->assertSuccessful()
        ->expectsOutput('optimize clear package-tools');
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
        ->expectsOutput('optimize package-tools');

    $this
        ->artisan('optimize:clear')
        ->assertSuccessful()
        ->expectsOutput('optimize clear package-tools');
})
    ->group('commands')
    ->skip(
        fn () => is_before_laravel_version(App::version(), '11.27.1'),
        message_before_laravel_version('11.27.1', 'hasOptimizeCommands')
    );
