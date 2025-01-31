<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasCommands
{
    public array $commands = [];
    public array $consoleCommands = [];

    public function hasCommands(...$commandClassNames): self
    {
        $this->commands = array_merge(
            $this->commands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }

    /* Legacy compatibility */
    public function hasCommand(...$commandClassNames): self
    {
        return $this->hasCommands(...$commandClassNames);
    }

    public function hasConsoleCommands(...$commandClassNames): self
    {
        $this->consoleCommands = array_merge(
            $this->consoleCommands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }

    /* Legacy compatibility */
    public function hasConsoleCommand(...$commandClassNames): self
    {
        return $this->hasConsoleCommands(...$commandClassNames);
    }
}
