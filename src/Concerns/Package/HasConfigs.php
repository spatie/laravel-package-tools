<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConfigs
{
    public array $configFileNames = [];
    public bool $discoversConfigs = false;
    protected string $configPath = '/../config';

    public function hasConfigFiles(...$configFileNames): self
    {
        $configFileNames = collect($configFileNames)->flatten()->toArray();

        if (count($configFileNames) == 1 and $configFileNames[0] == '*') {
            return $this->discoversConfigs();
        } elseif (count($configFileNames) == 0) {
            $configFileNames = [$this->shortName()];
        }

        $this->configFileNames = array_merge(
            $this->configFileNames,
            $configFileNames
        );

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasConfigFile(...$configFileNames): self
    {
        return $this->hasConfigFiles(...$configFileNames);
    }

    public function configPath(?string $directory = null): string
    {
        return $this->buildDirectory($this->configPath, $directory);
    }

    public function setConfigPath(string $path): self
    {
        $this->verifyDir($this->buildDirectory($path));
        $this->configPath = $path;

        return $this;
    }

    public function discoversConfigs(bool $discoversConfigs = true, ?string $path = null): self
    {
        $this->discoversConfigs = $discoversConfigs;
        $this->configPath = $path ?? $this->configPath;

        return $this;
    }
}
