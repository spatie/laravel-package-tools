<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConsoleCommands
{
    public array $consoleCommands = [];

    public function hasConsoleCommand(string $commandClassName): self
    {
        $this->consoleCommands[] = $commandClassName;

        return $this;
    }

    public function hasConsoleCommands(...$commandClassNames): self
    {
        $this->consoleCommands = array_merge(
            $this->consoleCommands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }
}
