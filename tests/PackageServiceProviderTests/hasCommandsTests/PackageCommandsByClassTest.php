<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasCommandsTests;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\FourthTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\OtherTestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\TestCommand;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands\ThirdTestCommand;

trait PackageCommandsByClassTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasRoute('web')
            ->hasCommandsByClass(TestCommand::class)
            ->hasCommandsByClass([OtherTestCommand::class])
            ->hasCommandsByClass(ThirdTestCommand::class, FourthTestCommand::class);
    }
}

uses(PackageCommandsByClassTest::class);

it("can register and execute Commands loaded by class name", function () {
    $this
        ->artisan('package-tools:test-command')
        ->assertSuccessful()
        ->expectsOutput('output of test command');

    $this
        ->artisan('package-tools:other-test-command')
        ->assertSuccessful()
        ->expectsOutput('output of other test command');
})->group('commands');

it("can register & execute a Command loaded by class name as part of a web transaction", function () {
    $response = $this->get('execute-command');

    expect($response->baseResponse->getStatusCode())->toBe(200);
    expect($response->baseResponse->getContent())->toContain('output of test command');
})->group('commands');
