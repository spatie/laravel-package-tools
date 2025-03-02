<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\TestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\ThirdTestCommand;

trait PackageCommandsByPathAltTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoutes('web')
                ->hasCommandsByPath('Console/Commands');
    }
}

uses(PackageCommandsByPathAltTest::class);

it("can register and execute Commands loaded by alternate path", function () {
    $this
        ->artisan('package-tools:test-command')
        ->assertSuccessful()
        ->expectsOutput('output of test command');

    $this
        ->artisan('package-tools:other-test-command')
        ->assertSuccessful()
        ->expectsOutput('output of other test command');
})->group('commands');

it("can register and execute a Command loaded by alternate path as part of a web transaction", function () {
    $response = $this->get('execute-command');

    expect($response->baseResponse->getStatusCode())->toBe(200);
    expect($response->baseResponse->getContent())->toContain('output of test command');
})->group('commands');
