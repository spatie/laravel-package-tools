<?php

namespace Spatie\LaravelPackageTools\Tests\TestPackage\Src\Commands;

use Illuminate\Console\Command;

class OptimizeClearCommand extends Command
{
    public $name = 'package-tools:clear-optimizations';

    public function handle()
    {
        $this->info('optimize clear package-tools');
    }
}
