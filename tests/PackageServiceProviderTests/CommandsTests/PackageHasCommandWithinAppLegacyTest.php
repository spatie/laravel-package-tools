<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\CommandsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\TestCommand;

trait PackageHasCommandWithinAppLegacyTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web')
            ->hasCommand(TestCommand::class);
    }
}

uses(PackageHasCommandWithinAppLegacyTest::class);

it('can execute a registered command in the context of the app', function () {
    $response = $this->get('execute-command');

    $response->assertSee('output of test command');
});
