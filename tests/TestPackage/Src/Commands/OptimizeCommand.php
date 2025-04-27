<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands;

use Illuminate\Console\Command;

class OptimizeCommand extends Command
{
    public $name = 'package-tools:optimize';

    public function handle()
    {
        $this->info('optimize package-tools');
    }
}
