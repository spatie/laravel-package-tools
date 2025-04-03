<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConfigs
{
    private static string $configDefaultPath = "../config";

    public array $configLoadsFiles = [];
    public array $configLoadsPaths = [];
    public array $configPublishesFiles = [];
    public array $configPublishesPaths = [];
    protected ?string $configsByNamePath = '../config';

    public function loadsConfigsByName(...$configFiles): self
    {
        return $this->handleConfigsByName(__FUNCTION__, $this->configLoadsFiles, ...$configFiles);
    }

    public function publishesConfigsByName(...$configFiles): self
    {
        return $this->handleConfigsByName(__FUNCTION__, $this->configPublishesFiles, ...$configFiles);
    }

    protected function handleConfigsByName(string $method, array &$names, ...$configFiles): self
    {
        $configFiles = collect($configFiles)->flatten()->toArray();

        if (! $configFiles) {
            $configFiles = [$this->shortName()];
        }

        $names = array_unique(array_merge(
            $names,
            $configFiles
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


    /* Legacy backwards compatibility */
    public function hasConfigFile(null|string|array $configFileName = null): self
    {
        return ($configFileName === null) ? $this->hasConfigFiles() : $this->hasConfigFiles($configFileName);
    }

    public function hasConfigFiles(...$configFiles): self
    {
        return $this
            ->loadsConfigsByName(...$configFiles)
            ->publishesConfigsByName(...$configFiles);
    }


    public function loadsConfigsByPath(?string $path = null): self
    {
        $this->configLoadsPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$configDefaultPath);

        return $this;
    }

    public function publishesConfigsByPath(?string $path = null): self
    {
        $this->configPublishesPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$configDefaultPath);

        return $this;
    }
}
