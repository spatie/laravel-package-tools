<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeTests;

use Illuminate\Support\Stringable;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\Tests\TestPackage\Src\Components\TestComponent;

trait PackageBladeCustomEchoTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->hasViews()
            ->hasBladeCustomEchoHandler(function (Stringable $message): string {
                return $message->upper();
            })
        ;
    }
}

uses(PackageBladeCustomEchoTest::class);

it("can load and use the blade custom echo handler", function () {
    $content = view('package-tools::custom-echo-test', ["str" => str("hello world")])->render();

    expect($content)->toStartWith('Stringable: HELLO WORLD');
})->group('blade');

