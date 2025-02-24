<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands\TestCommand;

trait PackageCommandWithinAppTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web')
            ->hasCommand(TestCommand::class);
    }
}

uses(PackageCommandWithinAppTest::class);

it('can execute a registered command in the context of the app', function () {
    $response = $this->get('execute-command');

    expect($response->baseResponse->getContent())->toContain('output of test command');
});
