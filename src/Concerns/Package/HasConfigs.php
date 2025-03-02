<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConfigs
{
    private static string $configDefaultPath = "../config";

    public array $configFilenames = [];
    public array $configPaths = [];
    protected ?string $configPath = '../config';

    public function hasConfigByName(...$configFilenames): self
    {
        $configFilenames = collect($configFilenames)->flatten()->toArray();

        if (! $configFilenames) {
            $configFilenames = [$this->shortName()];
        }

        $this->configFilenames = array_unique(array_merge(
            $this->configFilenames,
            $configFilenames
        ));

        $this->configPath = $this->verifyRelativeDirOrNull($this->configPath);

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

    public function hasConfigByPath(?string $path = null): self
    {
        $this->configPaths[] = $this->verifyRelativeDir(__FUNCTION__, $path ?? static::$configDefaultPath);

        return $this;
    }

    /* Legacy backwards compatibility */
    public function hasConfigFile(...$configFilenames): self
    {
        return $this->hasConfigByName(...$configFilenames);
    }

    public function hasConfigFiles(...$configFilenames): self
    {
        return $this->hasConfigByName(...$configFilenames);
    }
}
