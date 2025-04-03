<?php

namespace Spatie\LaravelPackageTools\Tests\PackageServiceProviderTests\hasBladeCustomDirectivesTests;

use Spatie\LaravelPackageTools\Package;

trait PackageLoadsBladeCustomIfTest
{
    public function configurePackage(Package $package)
    {
        $package
            ->name('laravel-package-tools')
            ->loadsViewsByPath()
            ->loadsBladeCustomIf('testif', function ($expression) {
                return $expression === "hello world";
            })
        ;
    }
}

uses(PackageLoadsBladeCustomIfTest::class);

it("can load and use the blade custom if statement", function () {
    $content = view('package-tools::custom-if-test', ['helloWorld' => "hello world"])->render();
    expect($content)->toStartWith('Success');

    $content = view('package-tools::custom-if-test', ['helloWorld' => "NOT hello world"])->render();
    expect($content)->toStartWith('Failure');
})->group('blade', 'blade-directives');
