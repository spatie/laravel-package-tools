<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait HasCommands
{
    private static string $commandsDefaultPath = "Commands";

    public array $commandClasses = [];
    public array $commandPaths = [];
    public array $consoleCommandClasses = [];
    public array $consoleCommandPaths = [];
    public array $optimizeCommands = [];

    public function loadsCommandsByClass(...$commandClassNames): self
    {
        return $this->handleConsoleCommandsByClass(__FUNCTION__, $this->commandClasses, ...$commandClassNames);
    }

    public function loadsConsoleCommandsByClass(...$commandClassNames): self
    {
        return $this->handleConsoleCommandsByClass(__FUNCTION__, $this->consoleCommandClasses, ...$commandClassNames);
    }

    protected function handleConsoleCommandsByClass(string $method, array &$classes, ...$commandClassNames): self
    {
        $classes = array_unique(array_merge(
            $classes,
            $this->verifyClassNames($method, $commandClassNames)
        ));

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasCommand(string $commandClassName): self
    {
        return $this->loadsCommandsByClass($commandClassName);
    }

    public function hasCommands(...$commandClassNames): self
    {
        return $this->loadsCommandsByClass(...$commandClassNames);
    }

    public function hasConsoleCommand($commandClassName): self
    {
        return $this->loadsConsoleCommandsByClass($commandClassName);
    }

    public function hasConsoleCommands(...$commandClassNames): self
    {
        return $this->loadsConsoleCommandsByClass(...$commandClassNames);
    }

    public function loadsCommandsByPath(?string $path = null): self
    {
        $this->commandPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$commandsDefaultPath);

        return $this;
    }

    public function loadsConsoleCommandsByPath(?string $path = null): self
    {
        $this->consoleCommandPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$commandsDefaultPath);

        return $this;
    }

    public function hasOptimizeCommands(?string $optimizeCommand = null, ?string $optimizeClearCommand = null): self
    {
        if (version_compare(app()->version(), '11.27.1') < 0) {
            throw InvalidPackage::laravelFunctionalityNotYetImplemented(
                $this->name,
                __FUNCTION__,
                '11.27.1'
            );
        }

        $optimizeCommand = $this->generateOptimizeCommandName($optimizeCommand, "optimize");
        $optimizeClearCommand = $this->generateOptimizeCommandName($optimizeClearCommand, "clear-optimizations");

        $this->optimizeCommands[] = [
            "optimize" => $optimizeCommand,
            "clear" => $optimizeClearCommand,
        ];

        return $this;
    }

    private function generateOptimizeCommandName(?string $cmd, string $defaultSubcmd): string
    {
        if (! $cmd) {
            return $this->shortName() . ":" . $defaultSubcmd;
        } elseif (strpos($cmd, ':') === false) {
            return $this->shortName() . ":" . $cmd;
        } else {
            return $cmd;
        }
    }
}
