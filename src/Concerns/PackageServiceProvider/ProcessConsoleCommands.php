<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessConsoleCommands
{
    protected function bootConsoleCommands()
    {
        if (empty($this->package->consoleCommands) || ! $this->app->runningInConsole()) {
            return;
        }

        $this->commands($this->package->consoleCommands);
    }
}
