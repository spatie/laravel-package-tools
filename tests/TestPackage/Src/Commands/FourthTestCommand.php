<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands;

use Illuminate\Console\Command;

class FourthTestCommand extends Command
{
    public $name = 'package-tools:fourth-test-command';

    public function handle()
    {
        $this->info('output of fourth test command');
    }
}
