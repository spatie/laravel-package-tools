<?php

namespace Spatie\LaravelPackageTools\Concerns\PackageServiceProvider;

use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Exceptions\InvalidPackage;

trait ProcessConfigs
{
    public function registerPackageConfigs(): self
    {
        return $this
            ->registerPackageConfigsByName()
            ->registerPackageConfigsByPath();
    }

    public function registerPackageConfigsByName(): self
    {
        if (empty($this->package->configLoadsFiles)) {
            return $this;
        }

        foreach ($this->package->configLoadsFiles as $configFilename) {
            /**
             * Laravel will only load/merge config files ending in .php so we cannot load or merge config .stub files
             **/
            if (is_file($cFN = $this->package->configsByNamePath("{$configFilename}.php"))) {
                $this->mergeConfigFrom(
                    $cFN,
                    $configFilename
                );
            } elseif (! is_file($this->package->configsByNamePath("{$configFilename}.php.stub"))) {
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Config',
                    'loadsConfigsByName',
                    $configFilename
                );
            }
        }

        return $this;
    }

    public function registerPackageConfigsByPath(): self
    {
        if (empty($this->package->configLoadsPaths)) {
            return $this;
        }

        foreach ($this->package->configLoadsPaths as $path) {
            foreach (glob($this->package->buildDirectory($path) . '/*.php') as $file) {
                if (is_file($file)) {
                    $this->mergeConfigFrom(
                        $file,
                        basename($file, '.php')
                    );
                }
            }
        }

        return $this;
    }

    public function bootPackageConfigs(): self
    {
        return $this
            ->bootPackageConfigsByName()
            ->bootPackageConfigsByPath();
    }

    protected function bootPackageConfigsByName(): self
    {
        if (empty($this->package->configPublishesFiles) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $shortName = $this->package->shortName();
        foreach ($this->package->configPublishesFiles as $configFilename) {
            if ($cFN = $this->phpOrStub($this->package->configsByNamePath($configFilename))) {
                $this->publishes(
                    [$cFN => config_path("{$configFilename}.php")],
                    "{$shortName}-config"
                );
            } else {
                throw InvalidPackage::filenameNeitherPhpNorStub(
                    $this->package->name,
                    'Config',
                    'publishesConfigsByName',
                    $configFilename
                );
            }
        }

        return $this;
    }

    protected function bootPackageConfigsByPath(): self
    {
        if (empty($this->package->configPublishesPaths) || ! $this->app->runningInConsole()) {
            return $this;
        }

        $tag = $this->package->shortName() . '-config';
        foreach ($this->package->configPublishesPaths as $path) {
            foreach (glob($this->package->buildDirectory($path) . '/*') as $file) {
                if (Str::endsWith($file, ['.php.stub', '.php']) && is_file($file)) {
                    $this->publishes(
                        [$file => config_path(basename(basename($file, '.php'), '.php.stub') . '.php')],
                        $tag
                    );
                }
            }
        }

        return $this;
    }
}
