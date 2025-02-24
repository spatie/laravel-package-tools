<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command
{
    public $name = 'test-command';

    public function handle()
    {
        $this->info('output of test command');
    }
}
