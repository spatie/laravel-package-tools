<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait HasCommands
{
    private static string $commandsDefaultPath = "Commands";

    public array $commands = [];
    public array $commandPaths = [];
    public array $consoleCommands = [];
    public array $consoleCommandPaths = [];
    public array $optimizeCommands = [];

    public function hasCommandsByClass(...$commandClassNames): self
    {
        $this->commands = array_unique(array_merge(
            $this->commands,
            $this->verifyClassNames(__FUNCTION__, $commandClassNames)
        ));

        return $this;
    }

    public function hasConsoleCommandsByClass(...$commandClassNames): self
    {
        $this->consoleCommands = array_unique(array_merge(
            $this->consoleCommands,
            $this->verifyClassNames(__FUNCTION__, $commandClassNames)
        ));

        return $this;
    }

    public function hasCommandsByPath(?string $path = null): self
    {
        $this->commandPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$commandsDefaultPath);

        return $this;
    }

    public function hasConsoleCommandsByPath(?string $path = null): self
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

        $optimizeCommand = $this->optimizeDefault($optimizeCommand, "optimize");
        $optimizeClearCommand = $this->optimizeDefault($optimizeClearCommand, "clear-optimizations");

        $this->optimizeCommands[] = [
            "optimize" => $optimizeCommand,
            "clear" => $optimizeClearCommand,
        ];

        return $this;
    }

    private function optimizeDefault(string $cmd, string $defaultSubcmd): string
    {
        if (! $cmd) {
            return $this->shortName() . ":" . $defaultSubcmd;
        } elseif (strpos($cmd, ':') === false) {
            return $this->shortName() . ":" . $cmd;
        } else {
            return $cmd;
        }
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
