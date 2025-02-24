<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Console\Commands;

use Illuminate\Console\Command;

class OtherTestCommand extends Command
{
    public $name = 'other-test-command';

    public function handle()
    {
        $this->info('output of other test command');
    }
}
