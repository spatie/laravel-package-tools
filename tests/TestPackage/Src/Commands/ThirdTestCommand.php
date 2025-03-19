<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands;

use Illuminate\Console\Command;

class ThirdTestCommand extends Command
{
    public $name = 'my-package:third-test-command';

    public function handle()
    {
        $this->info('output of third test command');
    }
}
