<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands;

use Illuminate\Console\Command;

class OtherTestCommand extends Command
{
    public $name = 'package-tools:other-test-command';

    public function handle()
    {
        $this->info('output of other test command');
    }
}
