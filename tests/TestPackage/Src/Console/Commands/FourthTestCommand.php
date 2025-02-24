<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands;

use Illuminate\Console\Command;

class FourthTestCommand extends Command
{
    public $name = 'fourth-test-command';

    public function handle()
    {
        $this->info('output of fourth test command');
    }
}
