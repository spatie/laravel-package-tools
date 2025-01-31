<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessConfigs
{
    public function registerPackageConfigs(): self
    {
        if ($this->package->discoversConfigs) {
            if (! empty($this->package->configFileNames)) {
                throw InvalidPackage::conflictingMethods(
                    $this->package->name,
                    'hasConfigs',
                    'discoversConfigs'
                );
            }

            $this->package->configFileNames = $this->convertDiscovers($this->package->configPath());
        }

        if (empty($this->package->configFileNames)) {
            return $this;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom(
                $this->phpOrStub($this->package->configPath("{$configFileName}")),
                $configFileName
            );
        }

        return $this;
    }

    protected function bootPackageConfigs(): self
    {
        if (empty($this->package->configFileNames) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $shortName = $this->package->shortName();
        foreach ($this->package->configFileNames as $configFileName) {
            $this->publishes(
                [$this->phpOrStub($this->package->configPath("{$configFileName}")) => config_path("{$configFileName}.php")],
                "{$shortName}-config"
            );
        }

        return $this;
    }
}
