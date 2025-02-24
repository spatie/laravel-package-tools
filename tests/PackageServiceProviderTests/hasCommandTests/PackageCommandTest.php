<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands\TestCommand;

trait PackageCommandTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasCommand(TestCommand::class);
    }
}

uses(PackageCommandTest::class);

it('can execute a registered commands', function () {
    $this
        ->artisan('test-command')
        ->assertSuccessful();
});
