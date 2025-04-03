<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

use Spatie\LaravelPackageTools\Commands\InstallCommand;

trait HasInstallCommand
{
    public ?InstallCommand $installCommand = null;

    public function hasInstallCommand(callable $callable): self
    {
        $this->installCommand = new InstallCommand($this);

        $callable($this->installCommand);

        $this->consoleCommandClasses[] = $this->installCommand;

        return $this;
    }
}
