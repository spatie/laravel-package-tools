<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessCommands
{
    protected function bootCommands()
    {
        if (empty($this->package->commands)) {
            return;
        }

        $this->commands($this->package->commands);
    }
}
