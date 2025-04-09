<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

trait ProcessConfigs
{
    public function registerPackageConfigs()
    {
        if (empty($this->package->configFileNames)) {
            return;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom($this->package->basePath("/../config/{$configFileName}.php"), $configFileName);
        }
    }

    protected function bootPackageConfigs(): self
    {
        if ($this->app->runningInConsole()) {
            foreach ($this->package->configFileNames as $configFileName) {
                $vendorConfig = $this->package->basePath("/../config/{$configFileName}.php");
                $appConfig = config_path("{$configFileName}.php");

                $this->publishes([$vendorConfig => $appConfig], "{$this->package->shortName()}-config");
            }
        }

        return $this;
    }
}
