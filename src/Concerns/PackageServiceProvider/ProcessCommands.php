<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessCommands
{
    protected function bootPackageCommands(): self
    {
        return $this
            ->bootPackageCommandsByClass()
            ->bootPackageCommandsByPath()
            ->bootPackageConsoleCommandsByClass()
            ->bootPackageConsoleCommandsByPath()
            ->bootPackageOptimizeCommands();
    }

    protected function bootPackageCommandsByClass(): self
    {
        if (empty($this->package->commandClasses)) {
            return $this;
        }

        $this->commands($this->package->commandClasses);

        return $this;
    }

    protected function bootPackageConsoleCommandsByClass(): self
    {
        if (empty($this->package->consoleCommandClasses) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $this->commands($this->package->consoleCommandClasses);

        return $this;
    }

    protected function bootPackageCommandsByPath(): self
    {
        if (empty($this->package->commandPaths)) {
            return $this;
        }

        $this->commands($this->getClassesInPaths('loadsCommandsByPath', $this->package->commandPaths));

        return $this;
    }

    protected function bootPackageConsoleCommandsByPath(): self
    {
        if (empty($this->package->consoleCommandPaths) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $this->commands($this->getClassesInPaths('loadsConsoleCommandsByPath', $this->package->consoleCommandPaths));

        return $this;
    }

    protected function bootPackageOptimizeCommands(): self
    {
        if (empty($this->package->optimizeCommands)) {
            return $this;
        }

        foreach ($this->package->optimizeCommands as $commandPair) {
            $this->optimizes(...$commandPair);
        }

        return $this;
    }
}
