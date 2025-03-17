<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConfigs
{
    private static string $configDefaultPath = "../config";

    public array $configsByNameFiles = [];
    public array $configPaths = [];
    protected ?string $configsByNamePath = '../config';

    public function hasConfigsByName(...$configsByNameFiles): self
    {
        $configsByNameFiles = collect($configsByNameFiles)->flatten()->toArray();

        if (! $configsByNameFiles) {
            $configsByNameFiles = [$this->shortName()];
        }

        $this->configsByNameFiles = array_unique(array_merge(
            $this->configsByNameFiles,
            $configsByNameFiles
        ));

        $this->configsByNamePath = $this->verifyRelativeDirOrNull($this->configsByNamePath);

        return $this;
    }

    public function setConfigsByNamePath(string $path): self
    {
        $this->configsByNamePath = $this->verifyRelativeDir(__FUNCTION__, $path);

        return $this;
    }

    public function configsByNamePath(?string $directory = null): string
    {
        return $this->verifyPathSet(__FUNCTION__, $this->configsByNamePath, $directory);
    }

    public function hasConfigsByPath(?string $path = null): self
    {
        $this->configPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$configDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasConfigFile(...$configsByNameFiles): self
    {
        return $this->hasConfigsByName(...$configsByNameFiles);
    }

    public function hasConfigFiles(...$configsByNameFiles): self
    {
        return $this->hasConfigsByName(...$configsByNameFiles);
    }
}
