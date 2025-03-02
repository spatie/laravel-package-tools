<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessCommands
{
    protected function bootPackageCommands(): self
    {
        $this
            ->bootPackageCommandsByClass()
            ->bootPackageCommandsByPath()
            ->bootPackageConsoleCommandsByClass()
            ->bootPackageConsoleCommandsByPath()
            ->bootPackageOptimizeCommands();

        return $this;
    }

    protected function bootPackageCommandsByClass(): self
    {
        if (empty($this->package->commands)) {
            return $this;
        }

        $this->commands($this->package->commands);

        return $this;
    }

    protected function bootPackageConsoleCommandsByClass(): self
    {
        if (empty($this->package->consoleCommands) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $this->commands($this->package->consoleCommands);

        return $this;
    }

    protected function bootPackageCommandsByPath(): self
    {
        if (empty($this->package->consoleCommandPaths)) {
            return $this;
        }

        $this->commands($this->getClassesInPaths('hasCommandsByPath', $this->package->commandPaths));

        return $this;
    }

    protected function bootPackageConsoleCommandsByPath(): self
    {
        if (empty($this->package->consoleCommandPaths) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $this->commands($this->getClassesInPaths('hasConsoleCommandsByPath', $this->package->consoleCommandPaths));

        return $this;
    }

    protected function bootPackageOptimizeCommands(): self
    {
        if (empty($this->package->optimizeCommands) || ! $this->app->runningInConsole()) {
            return $this;
        }

        foreach ($this->package->optimizeCommands as $commandPair) {
            $this->optimizes($commandPair);
        }

        return $this;
    }
}
