<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait HasConfigs
{
    public array $configFileNames = [];

    public function hasConfigFile($configFileName = null): self
    {
        $configFileName ??= $this->shortName();

        if (! is_array($configFileName)) {
            $configFileName = [$configFileName];
        }

        $this->configFileNames = $configFileName;

        return $this;
    }
}
