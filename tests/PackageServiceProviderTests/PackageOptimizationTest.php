<?php

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestClasses\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestClasses\TestCommand;

trait ConfigurePackageOptimizationTest
{
    public function configurePackage(Package $package)
    {
        $package->name('laravel-package-tools');

        if (version_compare(app()->version(), '11.27.1', '>=')) {
            $package->hasOptimization(TestCommand::class, OtherTestCommand::class, 'laravel-package-tools');
        }
    }
}

uses(ConfigurePackageOptimizationTest::class);

it('can call optimize commands', function () {
    if (version_compare(app()->version(), '11.27.1', '<')) {
        $this->markTestSkipped('Laravel 11+ functionality');
    }

    $this
        ->artisan('test-command')
        ->assertExitCode(0);
});

it('can call optimize:clear commands', function () {
    if (version_compare(app()->version(), '11.27.1', '<')) {
        $this->markTestSkipped('Laravel 11+ functionality');
    }

    $this
        ->artisan('other-test-command')
        ->assertExitCode(0);
});

it('registered optimize with laravel', function () {
    if (version_compare(app()->version(), '11.27.1', '<')) {
        $this->markTestSkipped('Laravel 11+ functionality');
    }

    $this->artisan('optimize')->expectsOutputToContain('laravel-package-tools');
});

it('registered optimize:clear with laravel', function () {
    if (version_compare(app()->version(), '11.27.1', '<')) {
        $this->markTestSkipped('Laravel 11+ functionality');
    }

    $this->artisan('optimize:clear')->expectsOutputToContain('laravel-package-tools');
});
