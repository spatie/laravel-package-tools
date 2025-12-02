<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessConfigs
{
    public function registerPackageConfigs(): self
    {
        if (empty($this->package->configFileNames)) {
            return $this;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $vendorConfig = $this->package->basePath("/../config/{$configFileName}.php");

            // Only mergeConfigFile if a .php file and not if a stub file
            if (! is_file($vendorConfig)) {
                continue;
            }

            $normalizedConfigKey = $this->normalizeConfigKey($configFileName);
            $this->mergeConfigFrom($vendorConfig, $normalizedConfigKey);
        }

        return $this;
    }

    protected function bootPackageConfigs(): self
    {
        if (empty($this->package->configFileNames) || ! $this->app->runningInConsole()) {
            return $this;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $vendorConfig ;
            if (
                ! is_file($vendorConfig = $this->package->basePath("/../config/{$configFileName}.php"))
                &&
                ! is_file($vendorConfig = $this->package->basePath("/../config/{$configFileName}.php.stub"))
            ) {
                continue;
            }

            $publishPath = $this->normalizePathForPublish($configFileName);
            $this->publishes(
                [$vendorConfig => config_path("{$publishPath}.php")],
                "{$this->package->shortName()}-config"
            );
        }

        return $this;
    }

    protected function normalizeConfigKey(string $configFileName): string
    {
        return str_replace(['/', '\\'], '.', $configFileName);
    }

    protected function normalizePathForPublish(string $configFileName): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $configFileName);
    }
}
