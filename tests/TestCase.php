<?php

namespace Spatie\LaravelPackageTools\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        /*
        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Spatie\\LaravelPackageTools\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
        */
    }
}
