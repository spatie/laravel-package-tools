<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasCommands
{
    public array $commands = [];

    public function hasCommand(string $commandClassName): self
    {
        $this->commands[] = $commandClassName;

        return $this;
    }

    public function hasCommands(...$commandClassNames): self
    {
        $this->commands = array_merge(
            $this->commands,
            collect($commandClassNames)->flatten()->toArray()
        );

        return $this;
    }
}
