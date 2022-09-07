<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\InstallCommandTests;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\PackageServiceProviderTestCase;
use Spatie\TestTime\TestTime;

class EndWithTest extends PackageServiceProviderTestCase
{
    protected string $stringFromEnd = '';

    public function configurePackage(Package $package)
    {
        TestTime::freeze('Y-m-d H:i:s', '2020-01-01 00:00:00');

        $package
            ->name('laravel-package-tools')
            ->hasConfigFile()
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->endWith(function (InstallCommand $installCommand) {
                    $this->stringFromEnd = "set by {$installCommand->getName()}";
                });
            });
    }

    /** @test */
    public function it_can_execute_the_end_with()
    {
        $this
            ->artisan('package-tools:install')
            ->assertSuccessful();

        $this->assertEquals('set by package-tools:install', $this->stringFromEnd);
    }
}
