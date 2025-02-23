<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait ProcessConfigs
{
    public function registerPackageConfigs(): self
    {
        if (empty($this->package->configFileNames)) {
            return $this;
        }

        foreach ($this->package->configFileNames as $configFileName) {
            /**
             * Laravel will only load/merge config files ending in .php so we cannot load or merge config .stub files
             **/
            if (is_file($cFN = $this->package->configPath("{$configFileName}.php"))) {
                $this->mergeConfigFrom(
                    $cFN,
                    $configFileName
                );
            }
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
            if ($cFN = $this->phpOrStub($this->package->configPath($configFileName))) {
                $this->publishes(
                    [$cFN => config_path("{$configFileName}.php")],
                    "{$shortName}-config"
                );
            } else {
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Config',
                    $configFileName
                );
            }
        }

        return $this;
    }
}
