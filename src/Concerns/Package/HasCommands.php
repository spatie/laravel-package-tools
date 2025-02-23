<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasCommands
{
    public array $commands = [];
    public array $commandPaths = [];
    public array $consoleCommands = [];
    public array $consoleCommandPaths = [];

    public function hasCommandsByClass(...$commandClassNames): self
    {
        $this->verifyClassNames(__FUNCTION__, $commandClassNames);

        $this->commands = array_merge(
            $this->commands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }

    public function hasConsoleCommandsByClass(...$commandClassNames): self
    {
        $this->verifyClassNames(__FUNCTION__, $commandClassNames);

        $this->consoleCommands = array_merge(
            $this->consoleCommands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }

    public function hasCommandsByPath(...$paths): self
    {
        $this->verifyRelativeDirs(__FUNCTION__, $paths);

        $this->commandPaths = array_merge(
            $this->commandPaths,
            collect($paths)->flatten()->toArray()
        );

        return $this;
    }

    public function hasConsoleCommandsByPath(...$paths): self
    {
        $this->verifyRelativeDirs(__FUNCTION__, $paths);

        $this->consoleCommandPaths = array_merge(
            $this->consoleCommandPaths,
            collect($paths)->flatten()->toArray()
        );

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasCommand(...$commandClassNames): self
    {
        return $this->hasCommandsByClass(...$commandClassNames);
    }

    public function hasCommands(...$commandClassNames): self
    {
        return $this->hasCommandsByClass(...$commandClassNames);
    }

    public function hasConsoleCommand(...$commandClassNames): self
    {
        return $this->hasConsoleCommandsByClass(...$commandClassNames);
    }

    public function hasConsoleCommands(...$commandClassNames): self
    {
        return $this->hasConsoleCommandsByClass(...$commandClassNames);
    }
}
