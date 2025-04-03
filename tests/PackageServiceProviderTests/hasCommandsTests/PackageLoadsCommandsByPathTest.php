<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsCommandsByPathTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web')
            ->loadsCommandsByPath();
    }
}

uses(PackageLoadsCommandsByPathTest::class);

it("can register and execute Commands loaded by default path", function () {
    $this
        ->artisan('package-tools:test-command')
        ->assertSuccessful()
        ->expectsOutput('output of test command');

    $this
        ->artisan('package-tools:other-test-command')
        ->assertSuccessful()
        ->expectsOutput('output of other test command');
})->group('commands');

it("can register and execute a Command loaded by default path as part of a web transaction", function () {
    $response = $this->get('execute-command');

    expect($response->baseResponse->getStatusCode())->toBe(200);
    expect($response->baseResponse->getContent())->toContain('output of test command');
})->group('commands');
