<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestClasses\TestCommand;

beforeAll(function () {

    $package = new Package();
    $package
        ->name('laravel-package-tools')
        ->hasRoutes('web')
        ->hasCommand(TestCommand::class);

    PackageServiceProviderConcreteTestCase::package($package);
});

it('can_execute_a_registered_command_in_the_context_of_the_app',function(){

    $response = $this->get('execute-command');

    $response->assertSee('output of test command');
});
