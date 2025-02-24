<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands;

use Illuminate\Console\Command;

class ThirdTestCommand extends Command
{
    public $name = 'third-test-command';

    public function handle()
    {
        $this->info('output of third test command');
    }
}
