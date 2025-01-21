<?php

namespace Spatie\LaravelPackageTools\Concerns\Package;

trait ProcessConfigs
{
    protected function convertDiscoversConfigs(): void
    {
        $this->package->configFileNames = $this->convertDiscovers($this->package->configPath());
    }

    public function registerConfigs()
    {
        if (empty($this->package->configFileNames)) {
            return;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom($this->package->basePath("/../config/{$configFileName}.php"), $configFileName);
        }
    }

    protected function bootConfigs()
    {
        if ($this->app->runningInConsole()) {
            foreach ($this->package->configFileNames as $configFileName) {
                $vendorConfig = $this->package->basePath("/../config/{$configFileName}.php");
                $appConfig = config_path("{$configFileName}.php");

                $this->publishes([$vendorConfig => $appConfig], "{$this->package->shortName()}-config");
            }
        }
    }
}
