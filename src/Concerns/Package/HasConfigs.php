<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConfigs
{
    public array $configFileNames = [];
    protected ?string $configPath = '/../config';

    public function hasConfigFiles(...$configFileNames): self
    {
        $configFileNames = collect($configFileNames)->flatten()->toArray();

        if (! $configFileNames) {
            $configFileNames = [$this->shortName()];
        }

        $this->configFileNames = array_merge(
            $this->configFileNames,
            $configFileNames
        );

        $this->configPath = $this->verifyDirOrNull($this->configPath);

        return $this;
    }

    public function configPath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->configPath, $directory);
    }

    public function setConfigPath(string $path): self
    {
        $this->configPath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasConfigFile(...$configFileNames): self
    {
        return $this->hasConfigFiles(...$configFileNames);
    }
}
